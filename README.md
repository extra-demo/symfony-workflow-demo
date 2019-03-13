# symfony-workflow-demo
symfony-workflow-demo


## doc 

https://symfony.com/doc/current/workflow/usage.html


## 使用过程

项目目录执行

```bash
php ./bin/console server:start
```

执行成功之后：

```bash
[OK] Server listening on http://127.0.0.1:8000
```

表示已经启动成功，在浏览器中打开地址即可。


## 工作流自定义

如果想自定义工作流，可以编辑 `config/packages/workflow.yaml`，中的 `places` 和 `transitions`。

### place: 流程状态

### transition: 状态流转操作

如果更新了工作流之后，需要执行 `php ./bin/console generateSvg` 生成对应的流程图。 这个依赖 `graphviz` 类库。
