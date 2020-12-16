# frame
php is beautiful

## 运行

本地测试可以使用php内置服务

`php -S 127001.run:8088 -t public public/index.php`

## 自动创建项目
```
1.需要github上创建一个开源项目并且发不到composer中
2.安装命令
php composer.phar create-project 0518yu/frame auto_web
```

## composer修改发布:
```
git tag 1.0.0
git push origin 1.0.0
```

自动更新:https://packagist.org/packages/0518yu/frame

## 关联git
```
git init
git remote add origin xxxxxxxxxx

git add .
git commit -m '初始化项目'
git push -u origin master

```