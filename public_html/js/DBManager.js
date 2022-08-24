let value = document.querySelector('.block').getAttribute('data-attr');

value.forEach(element => {
    alert(element);
});

// $.ajax({
//     url: "../php/empty.php",
//     type: 'POST',
//     data: {
//     // тут пишите данные в виде массива по которым нужно отфильтровать, что-то...
//     },
//     dataType: 'json',
//     contentType: 'application/json',
//     json: true
// }).done(function(data){
//     console.log(data);
// }).always(function(dataError){
//     console.log(dataError);
// });