# API Watcher

### 安装
```
git clone git@github.com:RunnerLee/api-watcher.git

composer install

php artisan migrate

php artisan admin:install

php artisan db:seed
```

### 配置微信群名及微信机器人 web server
*.env*
```
VBOT_NOTICE_USER=大丑逼
VBOT_SERVER_IP=127.0.0.1
VBOT_SERVER_PORT=9001
```

### 配置 API 分组
![](http://oupjptv0d.bkt.gdipper.com//image/github/api-watcher/DeepinScrot-4918.png)

### 增加 API
![](http://oupjptv0d.bkt.gdipper.com//image/github/api-watcher/DeepinScrot-0002.png)

### 为 API 添加请求参数
![](http://oupjptv0d.bkt.gdipper.com//image/github/api-watcher/DeepinScrot-0133.png)

### 为 API 分组增加计划任务
计划任务的条件, 通过 json 配置星期与小时.
```json
{
  "week": [],       // 周一到周日
  "hour": {
    "between": {    // 执行的时间范围
      "from": "",
      "to": ""
    },
    "unless_between": {     // 不执行的时间范围
      "from": "",
      "to": ""
    }
  }
}
```
![](http://oupjptv0d.bkt.gdipper.com//image/github/api-watcher/DeepinScrot-0435.png)

### 启动微信机器人
```
php vbot
```
以守护进程运行机器人, 需要手动拿到二维码链接然后扫码登录
```
nohup php vbot > /dev/null 2>&1 &
cat storage/vbot/url.txt
```
拿到链接 `https://login.weixin.qq.com/l/4bNWM4e8Uw==`, 替换为 `https://login.weixin.qq.com/qrcode/4bNWM4e8Uw==`


### 安装调度器
```
crontab -e
```
增加
```
* * * * * php /path/to/artisan schedule:run > /dev/null 2>&1 &
```

### 微信通知
![](http://oupjptv0d.bkt.gdipper.com//image/github/api-watcher/TIM%E6%88%AA%E5%9B%BE20170815122216.png)