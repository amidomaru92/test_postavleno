<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>

<button type="button" id="getRedisData">Get/Update</button>
<ul id="resultDataRedis"></ul>

<script>
    window.onload = getRedisData.click;
    getRedisData.onclick = async (e) => {
        e.preventDefault();

        let response = await fetch('/api/redis/', {
            method: 'GET',
        });

        const dt = await response.json();
        if (dt.status) {
            let listRedis = '';
            for (let x in dt.data) {
                listRedis+= `<li>{` + x + `}: {`+ dt.data[x] + `} <a href='#' class='remove' onclick='deleteRedisElement("`+x+`")'>delete</a></li>`;
            }
            resultDataRedis.innerHTML = listRedis;

        } else {
            alert("Ошибка HTTP: " + dt.data.message);
        }
    }
    
    async function deleteRedisElement(key) {
        let response = await fetch('/api/redis/' + key, {
            method: 'DELETE',
        });

        const dt = await response.json();
        if (dt.status) {
            alert("Удалено: ");
        } else {
            alert("Ошибка HTTP: " + dt.data.message);
        }
    }
</script>
</body>
</html>