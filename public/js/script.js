var btc = document.getElementById("bitcoin");
var eth = document.getElementById("ethereum");
var tether = document.getElementById("tether")


var settings = {
    "async": true,
    "url": "https://api.coingecko.com/api/v3/simple/price?ids=Bitcoin%2CEthereum%2CTether&vs_currencies=USD",
    "method": "GET",
    "headers": {}
}
$.ajax(settings).done(function (response){
    //console.log(response);
    btc.innerHTML = response.bitcoin.usd;
    eth.innerHTML = response.ethereum.usd;
    tether.innerHTML = response.tether.usd;
});