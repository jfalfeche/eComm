var _$_826d=["\x76\x61\x6C\x75\x65","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64","\x75\x70\x64\x61\x74\x65\x5F\x63\x61\x72\x74\x2E\x70\x68\x70","\x74\x72\x75\x65","\x68\x74\x6D\x6C","\x63\x68\x65\x63\x6B\x65\x72","\x62\x75\x74\x74\x6F\x6E","\x69\x6E\x6E\x65\x72\x48\x54\x4D\x4C","\x49\x6E\x76\x61\x6C\x69\x64\x20\x71\x75\x61\x6E\x74\x69\x74\x79\x2E","\x73\x74\x65\x70\x55\x70","\x74\x79\x70\x65","\x67\x65\x74","\x6C\x65\x6E\x67\x74\x68","\x67\x72\x61\x6E\x64\x54\x6F\x74\x61\x6C","\x44\x4F\x4D\x43\x6F\x6E\x74\x65\x6E\x74\x4C\x6F\x61\x64\x65\x64","\x63\x6C\x69\x63\x6B","\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74","\x73\x75\x62\x73\x74\x72\x69\x6E\x67","\x69\x64","\x63\x68\x61\x72\x41\x74","\x30","\x73\x74\x65\x70\x44\x6F\x77\x6E","\x31","\x6F\x6E","\x6B\x65\x79\x75\x70","\x69\x6E\x70\x75\x74","\x61\x64\x64\x45\x76\x65\x6E\x74\x4C\x69\x73\x74\x65\x6E\x65\x72"];function checkStock(c,b){let d=product[parseInt(c)];let f=document[_$_826d[1]](`quantity${c}`)[_$_826d[0]];$[_$_826d[11]](_$_826d[2],{check:_$_826d[3],action:d,quantity:f},function(h){$(`#checker`)[_$_826d[4]](h);let g=document[_$_826d[1]](_$_826d[5]);if(b== _$_826d[6]){if(parseInt(document[_$_826d[1]](`quantity${c}`)[_$_826d[0]])>= (quantity[parseInt(c)]+ parseInt(g[_$_826d[7]]))){alert(_$_826d[8])}else {document[_$_826d[1]](`quantity${c}`)[_$_826d[9]]()}}else {if(b== _$_826d[10]){if(parseInt(document[_$_826d[1]](`quantity${c}`)[_$_826d[0]])> (quantity[parseInt(c)]+ parseInt(g[_$_826d[7]]))){alert(_$_826d[8]);document[_$_826d[1]](`quantity${c}`)[_$_826d[0]]= (quantity[parseInt(c)]+ parseInt(g[_$_826d[7]]))}}};updateAll(c)})}function updateGrandTotal(){grandTotal= 0;for(i= 0;i< total[_$_826d[12]];i++){grandTotal+= total[i]};document[_$_826d[1]](_$_826d[13])[_$_826d[7]]= grandTotal}function updateTotal(c){var j=document[_$_826d[1]](`total${c}`);total[parseInt(c)]= document[_$_826d[1]](`quantity${c}`)[_$_826d[0]]* price[parseInt(c)];j[_$_826d[7]]= total[parseInt(c)]}function updateDatabase(c){var d=product[parseInt(c)];var f=document[_$_826d[1]](`quantity${c}`)[_$_826d[0]];$[_$_826d[11]](_$_826d[2],{update:_$_826d[3],action:d,quantity:f},function(h){$(`#quantity${c}`)[_$_826d[4]](h)})}function updateAll(c){quantity[parseInt(c)]= parseInt(document[_$_826d[1]](`quantity${c}`)[_$_826d[0]]);updateTotal(c);updateGrandTotal();updateDatabase(c)}document[_$_826d[26]](_$_826d[14],function(){$(_$_826d[6])[_$_826d[23]](_$_826d[15],function(a){a[_$_826d[16]]();q= this[_$_826d[18]][_$_826d[17]](1);if(this[_$_826d[18]][_$_826d[19]](0)== _$_826d[20]){if(parseInt(document[_$_826d[1]](`quantity${q}`)[_$_826d[0]])<= 1){alert(_$_826d[8]);return}else {document[_$_826d[1]](`quantity${q}`)[_$_826d[21]]();updateAll(q)}}else {if(this[_$_826d[18]][_$_826d[19]](0)== _$_826d[22]){checkStock(q,_$_826d[6])}}});$(_$_826d[25])[_$_826d[23]](_$_826d[24],function(){q= this[_$_826d[18]][_$_826d[17]](8);if(parseInt(this[_$_826d[0]])>= 1){}else {alert(_$_826d[8]);this[_$_826d[0]]= 1};checkStock(q,_$_826d[10])})})