# 用 laravel7.0 + vuejs2 做一個小購物車

#### 環境建置
##### 步驟1. start docker
```
> cd docker;
> docker-compose up -d;
```

##### 步驟2. 新增 .env 檔 + composer install + npm install
路徑：/cart
本機 php version：php@7.4
```
> cp .env.example .env
> composer install
> npm install
```

##### 步驟3. 瀏覽
http://localhost/cart

##### 如果修改 Vue ，記得先編譯後再瀏覽
```
安裝node> npm install
編譯指令> npm run dev
```

#### 開發工具
1. laravel 7.0
2. vue.js 2
