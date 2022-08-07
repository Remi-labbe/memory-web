"use strict";

// Ajout d'une fonction sur le type string pour gerer les donnees de la db
// Inutile depuis la transition vers jquery

String.prototype.jsonfromdb = function () {
  let string = this.replace(/\\/g, "");
  string = string.substring(1, string.lastIndexOf("\""));

  return JSON.parse(string);
}

// Fonction leaderboard

function get_ldb(sort){
  let target = "../src/traitement/fill_ldb.php?tri=" + sort;
  $.get(target)
    .done(function(data){
      fill_ldb(data);
    })
    .fail(function(data){
      console.log("Could'nt get data : " + data);
    });
}

function fill_ldb(content){
  if (content == "empty"){
    return;
  }
  let ldb = document.getElementById("ldb_body");
  ldb.innerHTML = content;
}
