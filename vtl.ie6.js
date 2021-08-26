/*! Copyright © 2015-2021 Alexey Vaskovsky. Released under the MIT license */
var btnBack = document.getElementById("btn-back");
if(btnBack) btnBack.onclick = function() {history.back(); return false;};
var btnPrint = document.getElementById("btn-print");
if(btnPrint) btnPrint.onclick = function() {window.print(); return false;};
var btnReload = document.getElementById("btn-reload");
if(btnReload) btnReload.onclick = function() {location.reload(); return false;};
