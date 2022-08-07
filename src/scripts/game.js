"use strict";

//------------------------------------------------------------------------------
// OBJECTS UTILES POUR LE JEU

// un simple objet qui represente une carte
class card {
  // val: int -> valeur de la carte
  // face: boolean -> determine la face visible
  constructor(value){
    this.val = value;
    this.face = false;
  }
}

// objet permettant de creer un plateau de jeu de memory
class memory {
  // ncards -> nombre de cartes sur le plateau
  //draw -> tirage des cartes de la partie en cours
  //attempts -> nombre d'essais
  //time -> temps depuis le debut de la partie
  constructor(n){
    this.ncards = n;
    this.draw = [];
    this.attempts = 0;
    this.time = null;
  }

  // Melange les cartes
  shuffle(array) {
    // taille du tableau a melanger -> nombre de cartes
    var counter = array.length;

    // tant qu'on a encore des elements a melanger
    while (counter > 0) {
        // determine un index aleatoire
        var index = Math.floor(Math.random() * counter);

        --counter;

        // echange la carte a l'index counter avec celle a l'index choisi aleatoirement.
        var temp = array[counter];
        array[counter] = array[index];
        array[index] = temp;
    }
  }

  // creer une liste de n paires.
  createrdmlist(n){
    var draw = [];
    // insertion de paires de cartes dans un tableau.
    for (let i = 0; i < n/2; ++i){
      draw.push(new card(i));
      draw.push(new card(i));
    }
    this.shuffle(draw);
    this.draw = draw;
  }

  // rempli le plateau de jeu
  fill(n){
    let plateau = document.getElementById("memory_board");
    // reset le plateau
    plateau.innerHTML = "";
    // ajout des nouvelles cartes
    for (let i = 0; i < n; ++i){
      plateau.innerHTML += "<img class='card' src='../src/img/hiddencard.png' id='" + i + "' alt='O'></img>";
    }
  }

}

//------------------------------------------------------------------------------
// SAUVEGARDE AUTOMATIQUE

//  On peut utiliser jquery pour faire de l'ajax,
//  jquery permet de ne pas se preoccuper de la compatibilite entre les
//    differents navigateurs

//  Relance la partie sauvegarder (si elle existe)
function resume() {
  let target = "../src/traitement/get_save.php";
  $.get(target)
    .done(function(data){
      fetch_saved_board(data);
    })
    .fail(function(data){
      console.log("Could'nt get data : " + data);
    });
}

//  affiche la partie sauvegardee sur le plateau
function fetch_saved_board(save){
  if (save == "no_data"){
    return;
  }
  // convertion de la chaine de caratere provenant de la base de donnees en
  //  objet JS.
  board = JSON.parse(save);
  // reset du compteur de paires trouvees
  foundpairs = 0;
  let b = board.draw;
  let plateau = document.getElementById("memory_board");
  // reset du plateau
  plateau.innerHTML = "";
  // ajout des nouvelles cartes
  for (let i = 0; i < b.length; ++i){
    // si la carte avait ete trouvee
    if (b[i].face){
      plateau.innerHTML += "<img class='card' src='../src/img/card"+ b[i].val +".png' id='" + i + "' alt='" + b[i].val + "'></img>";
      foundpairs += (1/2);
    // sinon
    } else {
      plateau.innerHTML += "<img class='card' src='../src/img/hiddencard.png' id='" + i + "' alt='O'></img>";
    }
  }
  timer_resume(board.time);
  document.getElementById("try").innerHTML = board.attempts;
  card1 = null;
  card2 = null;
  initcards();
}

// envoie de la sauvegarde (a chaque tour)
function send_save() {
  let target = "../src/traitement/send_save.php";
  let strboard = JSON.stringify(board);
  $.post(target, {content: strboard})
    .fail(function(data){
      console.log("save failed : " + data);
    });
}

// suppression de la sauvegarde (une fois la partie terminee)
function del_save() {
  let target = "../src/traitement/del_save.php";
  $.get(target)
    .fail(function(data){
      console.log("suppression failed : " + data);
    })
}

//------------------------------------------------------------------------------
// JEU

// Variable globale qui stocke le jeu en cours
var board;
// quelques variables qui gere les evennement/objets du jeu
var card1;
var card2;
var foundpairs;
var lockboard = false;
var ttf = null; // time to finish


// Lance une nouvelle partie. le nombre de carte (n) depend du niveau choisi
function start(n){
  let winp = document.getElementById("win");
  winp.innerHTML = "";
  board = new memory(n);
  board.createrdmlist(board.ncards);
  board.fill(board.ncards);
  document.getElementById("try").innerHTML = board.attempts;
  initcards();
  foundpairs = 0;
  card1 = null;
  card2 = null;
  timer_start();
}

// applique une fonction a toutes les cartes du plateau pour lancer le jeu
function initcards(){
  let cards = document.querySelectorAll('.card');
  cards.forEach(add_event);
}

// ajoute un evenement aux cartes qui sont encore jouable pour pouvoir les
//  retourner.
function add_event(card){
  if (!(board.draw[card.id].face)){
    card.addEventListener('click', turn);
  }
}

// verifie si les cartes retournees forment un parie
function match (c1, c2){
  c1 == c2 ? lock(card1, card2) : hide(card1, card2);
}

// retourne une carte
function flip(card){
  let c = board.draw[card.id];
  c.face = true;
  card.src = "../src/img/card" + c.val + ".png";
  card.alt = c.val;
}

// main function: appelee a chaque fois que le joueur clique sur une carte
//  disponible. Une fois que deux cartes sont retournees on verifie si elles
//  forment un paire. Si oui on desactive l'evennement sur ces cartes sinon on /
//  les retourne a nouveau.
function turn(){
  if (lockboard){
    return;
  }
  // premiere carte
  if (card1 == null){
    flip(this);
    card1 = this;
    return;
  // si on reclique sur la meme carte
  } else if (this == card1) {
    return;
  // deuxieme carte
  } else {
    flip(this);
    card2 = this;
  }
  // incremente le nombre d'essais
  ++board.attempts;
  document.getElementById("try").innerHTML = board.attempts;

  // On recupere la valeur de chaque carte pour rendre les appels de fonctions
  //   plus lisible.
  let v1 = board.draw[card1.id].val;
  let v2 = board.draw[card2.id].val;

  board.time = chrono.time;
  match(v1,v2);

  card1 = null;
  card2 = null;
}

// Desactive les cartes retournees au tour en cours. Si toutes les cartes sont
//  retournees, mets fin a la partie.
function lock(c1, c2){
  ++foundpairs;
  c1.removeEventListener('click', turn);
  c2.removeEventListener('click', turn);
  if (foundpairs == board.ncards/2){
    win();
  } else {
    send_save();
  }
}

// cache a nouveau les cartes quand elles ne correpondent pas.
function hide(c1, c2){
  lockboard = true;
  setTimeout(() => {
    board.draw[c1.id].face = false;
    board.draw[c2.id].face = false;
    c1.src = "../src/img/hiddencard.png";
    c2.src = "../src/img/hiddencard.png";
    c1.alt = "O";
    c2.alt = "O";
    send_save();
    lockboard = false
  }, 1000);
}

// fin de partie
function win (){
  del_save();
  timer_stop();
  update_highscore();
  let plateau = document.getElementById("memory_board");
  plateau.innerHTML = "";
  let winp = document.getElementById("win");
  winp.innerHTML = "<p style='border: red dashed 2px'>Vous avez gagné en "+ board.attempts +" coups</p>";
}

// mise a jour du meilleur score.
//  si l'ancien meilleur score etait meilleur ne fait rien.
function update_highscore(){
  let level = board.ncards / 8 - 1;
  let ttf = board.time;
  let tries = board.attempts;
  let target = "../src/traitement/update_highscore.php";
  $.post(target, {level: level, ttf: ttf, tries: tries})
    .fail(function(data){
      console.log("score update failed : " + data);
    });

}
