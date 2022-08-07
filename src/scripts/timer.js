"use strict";

//  Creation d'un objet pour l'utilisation d'un chronometre.

class timer {
  // t = temps en secondess
  constructor(t){
    this.time = t;
  }

  // fonction sur l'objet timer pour ecrire le temps au format h/m/s
  hour(){
    return Math.floor(this.time / 3600);
  }

  min(){
    return Math.floor((this.time - (this.hour() * 3600)) / 60);
  }

  sec(){
    return this.time % 60;
  }

  inc(){
    this.time += 1;
  }
}

var chrono = null;
var time;

// lance un nouveau chrono
function timer_start(){
  if (chrono != null){
    timer_stop();
  }
  chrono = new timer(0);
  document.getElementById("timer").innerHTML = chrono.hour() + " : " + chrono.min() + " : " + chrono.sec();
  time = setInterval(myTimer, 1000);
}

// relance le chrono ou il s'etait arrete
function timer_resume(time_s) {
  chrono = new timer(time_s);
  clearInterval(time);
  time = setInterval(myTimer, 1000);
}

// arrete le chrono au temps actuel
function timer_pause() {
  clearInterval(time);
}

// reset le chrono
function timer_stop() {
  clearInterval(time);
  chrono = null;
}

// fonction s'executant toutes les secondes pour faire avancer le chrono.
function myTimer() {
  chrono.inc();
  document.getElementById("timer").innerHTML = chrono.hour() + " : " + chrono.min() + " : " + chrono.sec();
}
