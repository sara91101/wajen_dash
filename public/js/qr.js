// var buffer = require(['buffer'], function (buf) { });
import { Buffer } from "./Buffer"
const bytes = [
    104, 116, 116, 112, 115,
    58, 47, 47, 119, 119,
    119, 46, 106, 118, 116,
    46, 109, 101
];
console.log(new Buffer(bytes).toString());
