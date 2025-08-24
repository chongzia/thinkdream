-- 创建 td_tickets 表的SQL脚本
-- 包含工单流程人当前位置字段

CREATE TABLE IF NOT EXISTS td_tickets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ticket_no VARCHAR(255) NOT NULL COMMENT '工单编号',
  ticket_name VARCHAR(255) NOT NULL COMMENT '工单标题',
  ticket_status INT NOT NULL DEFAULT 1 COMMENT '工单状态 (1:待处理, 2:处理中, 3:已完成, 4:已关闭)',
  ticket_priority INT NOT NULL DEFAULT 2 COMMENT '优先级 (1:低, 2:中, 3:高, 4:特)',
  ticket_promoter INT NOT NULL COMMENT '工单发起人',
  ticket_accept_at INT NULL COMMENT '工单受理日期',
  ticket_accept_overdue INT NOT NULL DEFAULT 0 COMMENT '工单受理超期 (0:未超期, 1:超期)',
  ticket_accept_days INT NOT NULL DEFAULT 1 COMMENT '工单受理天数',
  ticket_process_at INT NULL COMMENT '工单流程日期',
  ticket_process_overdue INT NOT NULL DEFAULT 0 COMMENT '工单流程超期 (0:未超期, 1:超期)',
  ticket_process_days INT NOT NULL DEFAULT 3 COMMENT '工单处理天数',
  ticket_node_id INT NOT NULL DEFAULT 1 COMMENT '工单节点',
  ticket_node_accept INT NOT NULL COMMENT '工单受理人',
  ticket_node_process TEXT NULL COMMENT '工单流程人',
  ticket_process_position INT NOT NULL DEFAULT 1 COMMENT '工单流程人当前位置',
  ticket_template INT NOT NULL COMMENT '工单模板',
  ticket_data TEXT NULL COMMENT '工单数据',
  created_at INT NOT NULL COMMENT '创建时间',
  updated_at INT NOT NULL COMMENT '更新时间',
  closed_at INT NULL COMMENT '关闭时间',
  
  -- 索引
  KEY idx_ticket_no (ticket_no),
  KEY idx_ticket_status (ticket_status),
  KEY idx_ticket_priority (ticket_priority),
  KEY idx_ticket_promoter (ticket_promoter),
  KEY idx_ticket_template (ticket_template),
  KEY idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='工单表';

-- 如果表已存在但缺少 ticket_process_position 字段，可以执行以下语句添加
-- ALTER TABLE td_tickets ADD COLUMN ticket_process_position INT NOT NULL DEFAULT 1 COMMENT '工单流程人当前位置' AFTER ticket_node_process;