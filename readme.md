# API Watcher

参考 [runscope](https://www.runscope.com/) 的一个 API 监控系统.


### 安装
```
git clone git@github.com:RunnerLee/api-watcher.git

composer install

php artisan migrate

php artisan admin:install

php artisan db:seed
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

### 配置钉钉群机器人
*.env*
```
DINGDING_ROBOT_TOKEN=xxxxxx
```

### 安装调度器
```
crontab -e
```
增加
```
* * * * * php /path/to/artisan schedule:run > /dev/null 2>&1 &
```

### TODO 
* 微信公众号/短信/邮件 告警
* API 文档生成