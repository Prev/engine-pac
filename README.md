# engine-pac

"engine pac" 는 API 서버의 개발속도, 유지보수, 공동 작업등을 쉽게 해 주는 코어입니다.

["engine pmc"](https://github.com/Prev/enigne-pmc) 에 기반하여 파생된 엔진입니다



# 사용

[oAuth](wikipedia.org/wiki/OAuth) 를 통신방법과 상당히 유사한 방법을 사용합니다.

Authorization 헤더와 Authorization-Signature 두가지 헤더를 사용하며 

Authorization 헤더는 `consumer_key`, `signature_method`, `nonce`, `timestamp` 4가지의 속성을 필요로 합니다

Authorization-Signature 헤더는 `<Method> <url encode 된 request uri> <url encode 된 Authorization 헤더> <url encode 된 GET/POST 변수>` 를 sha1 hmac 해시한 값입니다.

이중 Method 는 GET 이나 POST를 쓰고 Authorization 헤더는 `=` 과 `,` 로 구분합니다.

GET/POST 변수는 `&` 나 `=` 로 구분합니다.




pac 엔진으로 보내는 패킷을 보면 다음과 같습니다.
````
string(325) "GET http://127.0.0.1/pac/?module=test&action=testAction HTTP/1.0
Host: 127.0.0.1
User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64)
Authorization: consumer_key=YFUO1KLQ9GO8UFQRORZB,signature_method=hmacsha1,nonce=3FDO3FOUVINJ2Q5WBUYQ,timestamp=1375916135
Authorization-Signature: bcad842511b7a7ee1ba3ed0e3d8575b11c04954a
````


이중 Authorization-Signature 는 아래 값을 시크릿 키로 sha1 hash 한 값입니다.

`GET http%3A%2F%2F127.0.0.1%2Fpac%2F%3Fmodule%3Dtest%26action%3DtestAction consumer_key%3DYFUO1KLQ9GO8UFQRORZB%2Csignature_method%3Dhmacsha1%2Cnonce%3D9MBPVP8PB56OT1G3DAYD%2Ctimestamp%3D1375916611`


시크릿 키는 컨슈머키와 한쌍으로 존재하는 키이며 서버와 클라이언트 모두에 저장됩니다.


