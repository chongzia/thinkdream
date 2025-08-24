# 专业版接口文档

## 如何生成

```sh
php artisan catch:api:doc
```
## 启动文档
```shell
yarn install

yarn docs:dev
```

## 导入到 Apifox

使用 `php artisan catch:api:doc` 命令之后，会在 `api-doc` 根目录下生成 `postman.json` 元数据文件。

如图所示

![](https://image.catchadmin.com/202409171234566.png)

`项目设置` > `导入数据`

选择 `Postman`，点击 `导入` 即可
