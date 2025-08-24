import "./tailwind.css";
// .vitepress/theme/index.js
import DefaultTheme from "vitepress/theme";
import ApiEndpoint from "./components/ApiEndpoint.vue";
import ApiParameters from "./components/ApiParameters.vue";
import ApiResponse from "./components/ApiResponse.vue";
import ApiExample from "./components/ApiExample.vue";
import ApiHeader from "./components/ApiHeader.vue";
import "./styles/custom.css";

export default {
    ...DefaultTheme,
    enhanceApp({ app }) {
        app.component("ApiEndpoint", ApiEndpoint);
        app.component("ApiParameters", ApiParameters);
        app.component("ApiResponse", ApiResponse);
        app.component("ApiExample", ApiExample);
        app.component("ApiHeader", ApiHeader);
    },
};
