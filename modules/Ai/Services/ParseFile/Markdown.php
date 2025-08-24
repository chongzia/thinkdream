<?php

namespace Modules\Ai\Services\ParseFile;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Node\Block\Document; // Correct v2+ namespace
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Node\Node; // Or CommonMarkRenderer
// use League\CommonMark\Renderer\CommonMarkRenderer;
use League\CommonMark\Output\RenderedContentInterface;
use League\CommonMark\Renderer\HtmlRenderer; // For renderer return type

class Markdown extends ParserFile
{
    protected bool $includeHeadingsInContent = false;

    public function parse()
    {
        // --- Configure CommonMark ---
        $environment = new Environment;
        $environment->addExtension(new CommonMarkCoreExtension);
        // $environment->addExtension(new League\CommonMark\Extension\GithubFlavoredMarkdownExtension()); // Optional: Add GFM if needed

        $converter = new MarkdownConverter($environment);
        $renderer = new HtmlRenderer($environment); // Or CommonMarkRenderer

        // --- Read File ---
        if (! file_exists($this->file)) {
            throw new \Exception('Markdown file not found: '.$this->file);
        }
        $markdownContent = file_get_contents($this->file);

        // --- Parse Markdown ---
        $document = $converter->convert($markdownContent)->getDocument();
        dd($document);
        // --- Extract Hierarchical Chunks ---
        $chunks = [];
        $currentChunkNodes = [];
        $currentHeadingInfo = null; // ['title' => ..., 'level' => ...]

        // Use a walker to traverse all nodes in document order
        $walker = $document->walker();
        while ($event = $walker->next()) {
            $node = $event->getNode();
            // Entering a Heading node marks the end of the previous chunk
            // and the beginning of a new one.
            if ($node instanceof Heading && $event->isEntering()) {
                // 1. Finalize the PREVIOUS chunk (if there was one)
                if ($currentHeadingInfo !== null) {
                    // Render the collected nodes for the previous chunk
                    $content = $this->renderNodesToString($currentChunkNodes, $renderer);
                    // Add heading to content if requested
                    $chunkContent = $this->includeHeadingsInContent
                        ? $this->renderNodesToString([$currentHeadingInfo['node']], $renderer)."\n".trim($content)
                        : trim($content);

                    if (! empty($chunkContent) || $this->includeHeadingsInContent) { // Only add if there's content or if headings alone are desired
                        $chunks[] = [
                            'heading_title' => $currentHeadingInfo['title'],
                            'heading_level' => $currentHeadingInfo['level'],
                            'content' => $chunkContent,
                        ];
                    }
                }

                // 2. Start a NEW chunk based on the current heading
                $title = $this->extractNodeText($node);
                $level = $node->getLevel();
                $currentHeadingInfo = ['title' => $title, 'level' => $level, 'node' => clone $node]; // Store node for potential rendering
                $currentChunkNodes = []; // Reset node collector for the new chunk

                // Skip adding the Heading node itself to currentChunkNodes
                // It's handled by $currentHeadingInfo and optionally added at render time
                continue; // Move to the next node
            }

            // If we are inside a chunk (meaning a heading has been encountered)
            // and the node is not a Heading itself, collect it.
            // We only collect when *entering* the node to avoid duplication.
            if ($currentHeadingInfo !== null && $event->isEntering() && ! $node instanceof Heading && ! $node instanceof Document) {
                // Add a clone to avoid issues if node is moved later (though detach/appendChild in renderNodesToString should handle this)
                $currentChunkNodes[] = clone $node;
            }
        }

        // 3. Finalize the VERY LAST chunk after the loop finishes
        if ($currentHeadingInfo !== null) {
            $content = $this->renderNodesToString($currentChunkNodes, $renderer);
            $chunkContent = $this->includeHeadingsInContent
                ? $this->renderNodesToString([$currentHeadingInfo['node']], $renderer)."\n".trim($content)
                : trim($content);

            if (! empty($chunkContent) || $this->includeHeadingsInContent) {
                $chunks[] = [
                    'heading_title' => $currentHeadingInfo['title'],
                    'heading_level' => $currentHeadingInfo['level'],
                    'content' => $chunkContent,
                ];
            }
        }

        // Optional: Handle content before the first heading?
        // If needed, collect nodes before the first Heading is found and add as a separate chunk.

        dd($chunks);

        return $chunks;
    }

    /**
     * Extracts the plain text content from a node.
     */
    private function extractNodeText(Node $node): string
    {
        $textWalker = $node->walker();
        $textContent = '';
        while ($event = $textWalker->next()) {
            // Collect Text node literals when entering them
            if ($event->isEntering() && $event->getNode() instanceof Text) {
                $textContent .= $event->getNode()->getLiteral();
            }
        }

        return trim($textContent);
    }

    /**
     * Renders an array of nodes back to a string (HTML or Markdown).
     *
     * @param  array<Node>  $nodes
     * @param  HtmlRenderer|CommonMarkRenderer  $renderer
     */
    private function renderNodesToString(array $nodes, $renderer): string
    {
        if (empty($nodes)) {
            return '';
        }
        // Create a temporary document to hold nodes for rendering
        $tempDoc = new Document;
        foreach ($nodes as $sectionNode) {
            // Ensure node is detached if it has a parent before appending
            $sectionNode->detach();
            $tempDoc->appendChild($sectionNode);
        }
        // Render the temporary document containing only the section's nodes
        $rendered = $renderer->renderNodes([$tempDoc]);

        // Check if $rendered is an object (RenderedContentInterface) or string
        return $rendered instanceof RenderedContentInterface ? $rendered->getContent() : (string) $rendered;
    }

    // --- generateEmbeddings method remains the same ---
    public function generateEmbeddings(array $knowledgeData): array
    {
        // ... (Implementation depends on your embedding strategy) ...
        $vectorizedData = [];
        foreach ($knowledgeData as $item) {
            echo 'Generating embedding for section: '.$item['heading_title']."\n";
            // Example: Generate embedding from content, maybe add title context
            // $embedding = SomeEmbeddingService::generate($item['heading_title'] . "\n" . $item['content']);
            $vectorizedData[] = [
                'title' => $item['heading_title'],
                'level' => $item['heading_level'],
                'content' => $item['content'],
                'vector' => [], // Placeholder
            ];
        }

        return $vectorizedData;
    }
}
