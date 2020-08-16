# Ref
https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html

# API examples
## 1. Get all tlvc order
- GET: http://localhost/tlvc-api/api/tlvc-order/read.php?page=0&size=2
- Sample response
```
{
  "code": "0000",
  "message": "SUCCESS",
  "data": {
    "records": [
      {
        "id": "48",
        "name": "Zuka",
        "phone": "084302482",
        "address": "Viet Nam",
        "order_date": "2020-08-08 15:49:56",
        "message": "rpwa rlaew jaw rjewa lrpawep llew reaw rawkreoaw",
        "status": "CHƯA XỬ LÝ"
      },
      {
        "id": "47",
        "name": "Alice",
        "phone": "094832334",
        "address": "Japan",
        "order_date": "2020-08-08 10:42:56",
        "message": "lrpawep llew reaw raw",
        "status": "CHƯA XỬ LÝ"
      },
    ],
    "totalCount": "35"
  }
}
```

## 2. Create
- POST: http://localhost/tlvc-api/api/tlvc-order/create.php
- Sample body:
```
{
  "name" : "Vegeta",
  "phone" : "098384324",
  "address" : "Đà Nẵng, Việt Nam",
  "order_date" : "2020-08-11",
  "message" : "Hahaha",
  "status": "CHƯA XỬ LÝ"
}
```
- Sample response:
```
{
  "code": "0000",
  "message": "SUCCESS",
  "data": "TlvcOrder was created"
}
```

## 3. Update tlvc order
- PUT: http://localhost/tlvc-api/api/tlvc-order/update.php
- Sample body:
```
{
  "id": "6",
  "name" : "Vegeta 234",
  "phone" : "098384324",
  "address" : "Đà Nẵng, Việt Nam",
  "order_date" : "2020-08-11",
  "message" : "Hahaha",
  "status": "CHƯA XỬ LÝ"
}
```

## 4. Update status of list of tlvc orders
- POST: http://localhost/tlvc-api/api/tlvc-order/update-status.php
- Sample body:
```
{
  "idList": "1,2,3,4",
  "status": "THÀNH CÔNG"
}
```
- Sample response:
```
{
    "code": "0000",
    "message": "SUCCESS",
    "data": "Status of List of TlvcOrder were updated"
}
```