var main_window = document.getElementById('output');

$(document).on("click", ".user-info", () => {
    main_window.innerHTML = "<p>Введите ID: <input name='id' type='text'></p> <button class='search'>Найти</button>";
});

$(document).on("click", ".user-reg", () => {
    main_window.innerHTML = `
    <form id='reg' action='#' method='post'>
        <p>Имя: <input name='name' type='text'></p>
        <p>Почта: <input name='mail' type='mail'></p>
        <p>Телефон: <input name='phone' type='phone'></p>
        <p>Пароль: <input name='password' type='password'></p>
    </form>
    <button type='submit' class='reg'>Зарегистрироваться</button>
    `;
});

$(document).on("click", ".user-del", () => {
    main_window.innerHTML = "<p>Введите ID: <input name='id' type='text'></p> <button class='del'>Удалить</button>";
});

$(document).on("click", ".search", () => {
    showUser();
});

$(document).on("click", ".user-upd", () => {
    main_window.innerHTML = "<p>Введите ID: <input name='id' type='text'></p> <button class='upd-button'>Найти</button>";
});

$(document).on("click", ".del", () => {
    delUser();
});

$(document).on("click", ".reg", function () {
    let form_data=JSON.stringify(convertFormToJSON("#reg"));
    console.log (form_data);
    $.ajax({
        url: "../api/user/createUser.php",
        type : "POST",
        contentType : "application/json",
        data : form_data,
        success : (result) => {
            main_window.innerHTML = result.message;
        },
        error: () => {
            console.log('Ошибка на стороне сервера');
        }
    });
    return false;
});

$(document).on("click", ".upd-button", () => {
    let id = $('input[name="id"]').val();
    $.getJSON("http://restapi/api/user/search.php?id=" + id, data => {
        main_window.innerHTML = `
        <p>Обновление данных</p>
        <form id='update' action='#' method='post'>
            <p>ID: <input name='id' type='text' value='`+data.id+`' readonly></p>
            <p>Имя: <input name='name' type='text' value='`+data.name+`'></p>
            <p>Почта: <input name='mail' type='mail' value='`+data.mail+`'></p>
            <p>Телефон: <input name='phone' type='phone' value='`+data.phone+`'></p>
        </form>
        <button type='submit' class='update'>Обновить</button>
        `;
    });
});

$(document).on("click", ".update", function () {
    let upd_data=JSON.stringify(convertFormToJSON("#update"));
    $.ajax({
        url: "../api/user/updateUser.php",
        type : "POST",
        contentType : "application/json",
        data : upd_data,
        success : (result) => {
            main_window.innerHTML = result.message;
        },
        error: () => {
            console.log('Ошибка на стороне сервера');
        }
    });
    return false;
});

$(document).on("click", ".user-auth", () => {
    main_window.innerHTML = `
    <form id='auth' action='#' method='post'>
        <p>Почта: <input name='mail' type='mail'></p>
        <p>Пароль: <input name='password' type='password'></p>
    </form>
    <button type='submit' class='auth'>Войти</button>
    `;
});

$(document).on("click", ".auth", function () {
    let auth_data=JSON.stringify(convertFormToJSON("#auth"));
    console.log(auth_data);
    $.ajax({
        url: "../api/user/auth.php",
        type : "POST",
        contentType : "application/json",
        data : auth_data,
        success : (result) => {
            main_window.innerHTML = result.message;
        },
        error: () => {
            console.log('Ошибка на стороне сервера');
        }
    });
    return false;
});



function showUser() {
    let id_search = $('input[name="id"]').val();
    main_window.innerHTML = "Результаты поиска: ";
    $.getJSON("http://restapi/api/user/search.php?id=" + id_search, data => {
        let div = document.createElement("div");
        div.id = data.id;
        document.getElementById('output').append(div);
        document.getElementById(data.id).innerHTML = "<p> ID " + data.id + "<br>Имя: " + data.name + "<br>Почта: " + data.mail + "<br> Телефон: " + data.phone + "</p>";
    });
}

function delUser() {
    let id_delete = $('input[name="id"]').val();
    $.ajax({
        url: "../api/user/delete.php",
        type : "POST",
        dataType : "json",
        data : JSON.stringify({ id: id_delete }),
        success : result => {

            main_window.innerHTML = result.message;
        },
        error: () => {
            console.log("Ошибка на стороне сервера");
        }
    });
}

function convertFormToJSON(form) {
    const array = $(form).serializeArray();
    const json = {};
    $.each(array, function () {
      json[this.name] = this.value || "";
    });
    return json;
}