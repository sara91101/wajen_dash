var g1, g2, gg1, g7, g8, g9, g10;

// window.onload = function () {
//     var g1 = new JustGage({
//         id: "g1",
//         value: getRandomInt(0, 100),
//         min: 0,
//         max: 100,
//         title: "Big Fella",
//         label: "pounds"
//     });


//     setInterval(function () {
//         g1.refresh(getRandomInt(50, 100));
//     }, 2500);
// };




document.addEventListener("DOMContentLoaded", function (event) {
    //     g2 = new JustGage({
    //         id: "g2",
    //         value: 72,
    //         min: 0,
    //         max: 100,
    //         donut: true,
    //         gaugeWidthScale: 0.6,
    //         counter: true,
    //         hideInnerShadow: true
    //     });

    // document.getElementById('g2_refresh').addEventListener('click', function () {
    //     g2.refresh(getRandomInt(0, 100));
    // });

    // var g3 = new JustGage({
    //     id: 'g3',
    //     value: 65,
    //     min: 0,
    //     max: 100,
    //     symbol: '%',
    //     pointer: true,
    //     gaugeWidthScale: 0.6,
    //     customSectors: [{
    //         color: '#ff0000',
    //         lo: 50,
    //         hi: 100
    //     }, {
    //         color: '#00ff00',
    //         lo: 0,
    //         hi: 50
    //     }],
    //     counter: true
    // });

    var g4 = new JustGage({
        id: 'g4',
        value: activeCustomers,
        txtValue: activeCustomers,
        min: 0,
        max: customersNo,
        symbol: '%',
        pointer: true,
        pointerOptions: {
            toplength: -15,
            bottomlength: 10,
            bottomwidth: 12,
            color: '#8e8e93',
            stroke: '#ffffff',
            stroke_width: 3,
            stroke_linecap: 'round'
        },
        gaugeWidthScale: 0.6,
        counter: true
    });

    var g5 = new JustGage({
        id: 'g5',
        value: activeCustomers,
        min: 0,
        max: customersNo,
        symbol: '%',
        donut: true,
        pointer: true,
        width: 2500,
        gaugeWidthScale: 0.5,
        pointerOptions: {
            toplength: 10,
            bottomlength: 10,
            bottomwidth: 8,
            color: '#000'
        },
        customSectors: [{
            color: "#844fc1",
            lo: 1000,
            hi: 7000
        }, {
            color: "#844fc1",
            lo: 1000,
            hi: 5000
        }],
        counter: false
    });

    var g6 = new JustGage({
        id: 'g6',
        value: inActiveCustomers,
        min: 0,
        max: customersNo,
        symbol: '%',
        pointer: true,
        pointerOptions: {
            toplength: 8,
            bottomlength: -20,
            bottomwidth: 6,
            color: '#8e8e93'
        },
        gaugeWidthScale: 0.1,
        counter: true
    });

    var g7 = new JustGage({
        id: 'g7',
        value: 65,
        min: 0,
        max: 100,
        reverse: true,
        gaugeWidthScale: 0.6,
        customSectors: [{
            color: '#ff0000',
            lo: 50,
            hi: 100
        }, {
            color: '#00ff00',
            lo: 0,
            hi: 50
        }],
        counter: true
    });

    var g8 = new JustGage({
        id: 'g8',
        value: 45,
        min: 0,
        max: 500,
        reverse: true,
        gaugeWidthScale: 0.6,
        counter: true
    });

    var g9 = new JustGage({
        id: 'g9',
        value: 25000,
        min: 0,
        max: 100000,
        humanFriendly: true,
        reverse: true,
        gaugeWidthScale: 1.3,
        customSectors: [{
            color: "#ff0000",
            lo: 50000,
            hi: 100000
        }, {
            color: "#00ff00",
            lo: 7000,
            hi: 50000
        }],
        counter: true
    });

    var g10 = new JustGage({
        id: 'g10',
        value: 90,
        min: 0,
        max: 100,
        symbol: '%',
        reverse: true,
        gaugeWidthScale: 0.1,
        counter: true
    });


});
