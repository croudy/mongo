
/*
 * GET home page.
 */

var model = require('../model');
var ejs = require('ejs');
var fs = require('fs');
var keitai = model.keitai;
var qs=require('querystring');
var forms =  ""
var keyword = { 
  "number" : {"type" : "equal"},
  "mail"   : {"type" : "like"},
  "name"   : {"type" : "like"},
  "date"   : {"type" : "like"},
  "id"     : {"type" : "like"},
  "body"   : {"type" : "like"}
} ;
var page = 0;
var skip = 0;
var limit = 10;

exports.index = function(req, res){
  var where = new Object();
  for(var i in keyword ){
    if( req.query[i] == "" || req.query[i] == undefined ){
      req.query[i] = "";
    }
    else{
      if( keyword[i]["type"] == "like" ){
        var regex = new RegExp(req.query[i]);
        where[i] = regex; 
      }
      else{
        where[i] = req.query[i]; 
      }
    }
  }
  console.log('req.query');
  console.log(req.query);
  console.log('where');
  console.log(where);
  console.log("index.page="+req.query.page);

  if( req.query.page == undefined ){
    req.query.page = 0; 
  }
  skip = req.query.page * limit;
  page = req.query.page;

  keitai.find( where ,{}, { skip:skip, limit:10, sort:{"_id":1} }, function(err, items){
    //console.log(items);
    res.render('index', { title: '検索', query: req.query, items: items, page: page })
  });
};
