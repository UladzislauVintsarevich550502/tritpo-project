var GAME = {
    modes: {
        tiny: {x: 8, y: 8, n: 10, t1: 30, t2: 10, t3: 4},
        normal: {x: 16, y: 16, n: 40, t1: 70, t2: 40, t3: 26},
        expert: {x: 30, y: 16, n: 99, t1: 250, t2: 150, t3: 100},
        epic: {x: 60, y: 32, n: 320, t1: 999, t2: 500, t3: 250} /* should check this */
    },
    storage: null,
    _make_threads: 0, /* for debug only */
    slowpoke: false,
    map: null
};

function $12(s) {
    return document.querySelector(s);
}

function $1(s) {
    return document.getElementById(s);
}

function MinesweeperMap(ops) {
    var _m = this;

    ////////// FUNCTIONS
    var d = [
        {x: -1, y: -1},
        {x: -1, y: 0},
        {x: -1, y: 1},
        {x: 0, y: -1},
        {x: 0, y: 1},
        {x: 1, y: -1},
        {x: 1, y: 0},
        {x: 1, y: 1}
    ];

    _m.getCell = function (x, y) {
        if (1 * x > _m.width || 1 * y > _m.height) {
            return false;
        }
        if (1 * x < 0 || 1 * y < 0) {
            return false;
        }
        if (!(_m.cells[y] instanceof Array)) {
            return false;
        }
        //if( !(_m.cells[y][x] instanceof Object)) {
        //	return false;
        //}
        return _m.cells[y][x];
    };

    _m.preCount3BV = function (w, h) {
        var z = null;
        for (var i = 0; i < h; i++) {
            for (var j = 0; j < w; j++) {
                z = _m.getCell(j, i);													//$12('#c-x' + j + 'y' + i).style.background = "_lime";
                if (z.hasBomb) {
                    z.q_3bv = -1;														//$12('#c-x' + j + 'y' + i).style.background = "magenta";
                    continue;
                }
                if (z.q == 0) {
                    if (z.q_3bv == 0) {
                        z.q_3bv = 1;														//$12('#c-x' + j + 'y' + i).style.background = "red"; $12( '#c-x' + j + 'y' + i ).style.outline = "2px solid orange;";
                    }
                    _m.fillArea3BV(j, i);
                }
            }
        }
    };

    _m.count3BV = function (w, h) {
        _m.preCount3BV(w, h);
        var c = 0, z = null;
        for (var i = 0; i < h; i++) {
            for (var j = 0; j < w; j++) {
                z = _m.getCell(j, i);
                if (z.q_3bv > -1) {
                    c++;																//$12('#c-x' + j + 'y' + i).style.background = "green";
                }
            }
        }
        return c;
    };

    _m.fillArea3BV = function (x, y) {
        for (var i = 0; d[i]; i++) {
            var z = _m.getCell(x + d[i].x, y + d[i].y);
            if (!z) {
                continue;
            }
            //var s = '#c-x' + (x + d[i].x)*1 + 'y' + (y + d[i].y)*1;						//$12( s ).style.outline = "1px solid red;";
            if (z.q_3bv == 0) {
                z.q_3bv = -1;															//$12( s ).style.outline = "1px solid blue";
                if (z.q == 0) {
                    _m.fillArea3BV(x + d[i].x, y + d[i].y);
                }
            }
        }
        return;
    };

    _m.countBombs = function (x, y) {
        return _m.count(x, y, 'hasBomb');
    };

    _m.countFlags = function (x, y) {
        return _m.count(x, y, 'flag');
    };

    _m.count = function (x, y, what) {
        var c = 0, z;
        for (var i = 0; d[i]; i++) {
            z = _m.getCell(1 * x + d[i].x, 1 * y + d[i].y);
            if (z) {
                c += z[what] ? 1 : 0;
            }
        }
        return c;
    };

    var id2xy = function (id) {
        var x = id.split('y');
        var y = x[1];
        x = x[0].split('x')[1];
        return {'x': x, 'y': y};
    };

    _m.force = function (rawId) {
        var r = id2xy(rawId);
        return _m.forceCells(r.x, r.y);
    };

    _m.flag = function (rawId, el) {
        var el = el | null;
        var r = id2xy(rawId);
        return _m.toggleFlag(r.x, r.y, el);
    };

    _m.open = function (rawId, el) {
        var el = el | null;
        var r = id2xy(rawId);
        return _m.openCell(r.x, r.y, el);
    };

    _m.toggleFlag = function (x, y, el) {
        var cell = _m.getCell(x, y);
        if (!cell) {
            return false;
        }
        if (cell.isOpen) {
            return false;
        }
        if (!el) {
            var el = $1('t-x' + x + 'y' + y);
        }
        if (cell.flag) {
            cell.flag = false;
            el.className = 'tile';
            _m.flagsLeft++;
            return true;
        }
        if (_m.flagsLeft < 1) {
            return false;
        }
        cell.flag = true;
        el.className = 'tile flag';
        _m.flagsLeft--;
        return true;
    };

    _m.forceCells = function (x, y) {
        var cell = _m.getCell(x, y);
        if (!cell) {
            return false;
        }
        if (!cell.isOpen) {
            return false;
        }
        if (_m.countFlags(x, y) == cell.q && cell.q > 0) {
            var rF = false;
            for (var i = 0; d[i]; i++) {
                rF |= _m.openCell(1 * x + d[i].x, 1 * y + d[i].y);
            }
            return rF;
        }
        return false; // kinda overkill
    };

    _m.openCell = function (x, y, el) {
        if (_m.state == 'ready') {
            _m.state = 'active';
            _m.startTime = (new Date()).getTime();
        }
        if (_m.state == 'defeat' || _m.state == 'victory') {
            return false;
        }
        var cell = _m.getCell(x, y);
        if (!cell) {
            return false;
        }
        if (cell.flag) {
            return false;
        }
        if (cell.isOpen) {
            return false;
        }
        if (!el) {
            var el = $1('t-x' + x + 'y' + y);
        }
        if (cell.hasBomb) {
            if (_m.clicks < 2) {
                _m.re(x, y);
            } else {
                _m.die(el);
            }
            return false;
        }
        cell.isOpen = true;
        el.innerHTML = (cell.q > 0) ? cell.q : '';
        el.className = 'td x' + cell.q;
        _m.cellsLeft--;
        if (_m.cellsLeft < 1) {
            _m.win();
        }
        if (cell.q == 0) {
            for (var i = 0; d[i]; i++) {
                _m.openCell(1 * x + d[i].x, 1 * y + d[i].y);
            }
        }
        return true;
    };

    _m.win = function () {
        $.ajax({
            type: "post",
            url: "../../php_include/saveStatistic.php",
            data: "type=victorySapper",
            dataType: "html",
            cache: false,
            success: function (data) {
            }
        });
        _m.state = 'victory';
        _m.endTime = (new Date()).getTime();
        _m.totalTime = ((_m.endTime - _m.startTime) * 0.001).toFixed(0);
        var overlay = document.createElement('div');
        overlay.className = 'overlay victory';
        overlay.innerHTML = '<span>' + _m.totalTime + '</span>';
        $1('map').appendChild(overlay);
        $1('timer1').innerHTML = _m.totalTime;
        $1('map').className = 'win';
        // save
        var ls = GAME.storage;
        var k = 'record-' + modeName;
        if (!(k in ls)
            || typeof ls[k] == 'undefined'
            || 1 * ls[k] > _m.totalTime
        ) {
            ls[k] = _m.totalTime;
            parseRecord(modeName);
        }
    };

    _m.re = function (x, y) {
        _m.state = 'defeat';
        remake(modeName, x, y);
    };

    _m.die = function (el) {
        _m.state = 'defeat';
        var cooldown = 1000;
        var game_duration = (new Date()).getTime() - _m.startTime;
        switch (true) {
            case (game_duration > 30000):
                cooldown = 1500;
                break;
            case (game_duration > 15000):
                cooldown = 800;
                break;
            case (game_duration > 5000):
                cooldown = 200;
                break;
            default:
                cooldown = 0; //125;
                break;
        }
        if (el) {
            el.className = 'td bomb fail';
        }
        var overlay = document.createElement('div');
        overlay.className = 'overlay gameover';
        if (_m.width < 100) {
            overlay.innerHTML = '<span></span>';
        }else {
            overlay.innerHTML = '<span>TRY AGAIN</span>';
        }
        $1('map').appendChild(overlay);
        setTimeout(function () {
            if (overlay) {
                overlay.className = 'overlay gameover re';
                overlay.addEventListener('click', function () {
                    make(modeName);
                }, false);
            }
        }, cooldown);

        $.ajax({
            type: "post",
            url: "../../php_include/saveStatistic.php",
            data: "type=looserSapper",
            dataType: "html",
            cache: false,
            success: function (data) {
            }
        });

        _m.showBombs();
    };

    _m.showBombs = function () {
        for (var i = 0; _m.getCell(i, 0); i++) {
            for (var j = 0; _m.getCell(i, j); j++) {
                if (!_m.getCell(i, j).hasBomb && _m.getCell(i, j).flag) {
                    var t = $1('t-x' + i + 'y' + j);
                    t.innerHTML = "'"; // wrong flag marker
                    t.className += ' wrong';
                }
            }
        }
        $1('map').className = 'defeat';
    };

    _m.plantBombs = function () {
        var
            r = Math.random,
            x = _m.width,
            y = _m.height,
            cycles_max = x * y,
            c = 0,
            i = 0,
            x1 = 0,
            y1 = 0;

        while (i < _m.bombs) {
            x1 = (r() * (x - 1)).toFixed(0);
            y1 = (r() * (y - 1)).toFixed(0);
            var z = _m.getCell(x1, y1);
            if (!z) {
                continue;
            }
            if (z.isSafe) {
                continue;
            }
            if (!z.hasBomb) {
                z.hasBomb = true;
                i++;
            }
            c++;
            if (c > cycles_max) {
                throw('execution cycle limit reached');
                break;
            }
        }
    };

    _m.indexMap = function () {
        for (var i = 0; i < _m.height; i++) {
            for (var j = 0; j < _m.width; j++) {
                if (_m.cells[i][j].hasBomb) {
                    continue;
                }
                _m.cells[i][j].q = _m.countBombs(j, i);
            }
        }
    };
    ///
    var modeName = ops.mode;
    ops.x = (1 * ops.x).toFixed(0);
    ops.y = (1 * ops.y).toFixed(0);
    ops.n = (1 * ops.n).toFixed(0);

    var _x = ops.x;
    var _y = ops.y;
    var _n = ops.n;

    _m.width = ops.x;
    _m.height = ops.y;

    _m.bombs = (_n > (_x * _y)) ? (_x * _y - 1) : _n;
    var x3bv_limit = _n - 1;

    _m.cells = [];
    for (var i = 0; i < _y; i++) {
        _m.cells[i] = [];
        for (var j = 0; j < _x; j++) {
            _m.cells[i][j] = {
                hasBomb: false,
                isSafe: false,
                flag: false,
                q_3bv: 0
            };
        }
    }
    if (ops.re) {
        try {
            //console.log('remaking map..');
            var z = _m.getCell(ops.safeX, ops.safeY);
            z.isSafe = true;
        } catch (err) {
            //console.log('unable to remake' + err);
            _m.die();
        }
    }

    var x3bv = 0;
    for (var i = 0; x3bv < x3bv_limit || i > 10; i++) {
        _m.plantBombs();
        _m.indexMap();
        x3bv = _m.count3BV(_x, _y);
    }

    _m.cellsLeft = _x * _y - _n;
    _m.flagsLeft = _n;
    _m.startTime = 0;
    _m.endTime = 0;
    _m.clicks = 0;
    _m.clicksWasted = 0;

    $1('hud').className = '';
    _m.state = 'init'; // 'active', 'paused', 'defeat', 'victory'
    return _m;
}

try {
    /* hide from old browsers */
    CanvasRenderingContext2D.prototype.fillRoundedRect = function fillRoundedRect(x, y, w, h, r) {
        this.beginPath();
        this.moveTo(x + r, y);
        this.lineTo(x + w - r, y);
        this.quadraticCurveTo(x + w, y, x + w, y + r);
        this.lineTo(x + w, y + h - r);
        this.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
        this.lineTo(x + r, y + h);
        this.quadraticCurveTo(x, y + h, x, y + h - r);
        this.lineTo(x, y + r);
        this.quadraticCurveTo(x, y, x + r, y);
        this.fill();
    };
} catch (e) {

}


function bakeGradients() {
    var canvas = document.createElement('canvas');
    canvas.width = 25;
    canvas.height = 25;
    try {
        var ctx = canvas.getContext('2d');
    } catch (e) {
        throw ('browser does not support canvas. ' + e);
    }
    var _bg = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
    _bg.addColorStop(0.05, '#f9fbfd');
    _bg.addColorStop(0.65, '#d3d5d7'); //	  '#d3d5d7');
    var _border = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
    _border.addColorStop(0.45, '#ffffff');
    _border.addColorStop(0.55, '#707070');

    // assign gradients to fill and stroke styles
    ctx.fillStyle = _bg;
    ctx.strokeStyle = _border;

    ctx.fillRoundedRect(1, 1, canvas.width - 2, canvas.height - 2, 3);
    ctx.stroke();
    var _bg1x = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
    _bg1x.addColorStop(0.05, '#d3d5d7'); //	  '#d3d5d7');
    _bg1x.addColorStop(0.65, '#e3e5e7');

    ctx.fillStyle = _bg1x;
    ctx.strokeStyle = 'rgba(0,0,0,0)';
    ctx.fillRoundedRect(4, 4, canvas.width - 8, canvas.height - 8, 4);
    ctx.stroke();
    var _img = "#map .tile { ";
    _img += "background: #d3d5d7 url('" + canvas.toDataURL() + "') no-repeat;";
    _img += " }";


    ctx.globalAlpha = 0.15;
    ctx.fillStyle = '#FF0000';
    ctx.strokeStyle = '#FF0000';
    ctx.fillRoundedRect(1, 1, canvas.width - 2, canvas.height - 2, 3);
    ctx.stroke();
    //
    _img += "#map .flag.wrong { ";
    _img += "background: #d3d5d7 url('" + canvas.toDataURL() + "') no-repeat;";
    _img += " }";

    $12('style#textures').innerHTML = _img; // hack to allow playing from google cached version
    canvas = null;
    ctx = null;
}

function renderToHTML(obj) {
    if (!obj) {
        return false;
    }
    var _tiles = '';
    for (var i = 0; i < obj.height; i++) {
        for (var j = 0; j < obj.width; j++) {
            var z = obj.getCell(j, i);
            if (z) {
                var _xClass = '';
                if (z.hasBomb) {
                    _xClass = ' bomb';
                }
                if (z.q > 0) {
                    _xClass = ' x' + z.q;
                }
                var t = 25 * i;
                var l = 25 * j;
                _tiles += '<div class="tile' + _xClass + '" id="t-x' + j + "y" + i + '" style="top: ' + t + 'px; left: ' + l + 'px;" >+</div>';
            }
        }
    }
    var _header = '<div class="about">' + obj.width + 'x' + obj.height + ', ' + obj.bombs + ' bombs.' + '</div>';
    var _rasporka3 = "width: " + 25 * obj.width + "px; height: " + 25 * obj.height + "px;";
    $1('map').setAttribute('style', _rasporka3);
    obj.state = 'ready';
    return (_tiles + _header);
}

function attachIO() {

    var poke = function (e) {
        var done = false;
        var m = GAME.map;
        m.clicks++;
        e.preventDefault();
        if (e.target.className.indexOf('tile') !== -1) {
            if (e.button === 2 || (e.button === 0 && e.ctrlKey === true)) {
                done = m.flag(e.target.id, e.target);
            }
            if (e.button === 0 && e.ctrlKey === false) {
                done = m.open(e.target.id, e.target);
            }
            if (!done) {
                m.clicksWasted++;
            }
            e.stopPropagation();
            return true;
        }
        if (e.target.className.indexOf('td') !== -1) {
            if (e.button == 0) {
                done = m.force(e.target.id);
            }
            if (!done) {
                m.clicksWasted++;
            }
            return true;
        }
    };

    var timerCycle = function () {
        var output = $12('#timer1');
        var output3 = $12('#cells1');
        var output4 = $12('#clicks1');

        setInterval(function () {
            var m = GAME.map;
            if (!m) {
                return false;
            }
            output3.innerHTML = m.cellsLeft;
            if (m.state != 'active') {
                return false;
            }
            output4.innerHTML = (m.clicks - m.clicksWasted) + ' (' + m.clicks + ')';
            output.innerHTML = (m.startTime > 0) ? (((new Date()).getTime() - m.startTime) * 0.001).toFixed(0) : 0;
        }, 1000);
    };

    timerCycle();
    $1('map').addEventListener('mousedown', poke, false);
    $1('map').addEventListener('click', function (e) {
        /* futile attempt to fix double tap on iPad */
        e.preventDefault();
        return false;
    }, false);
    $1('map').addEventListener('contextmenu', function (e) {
        e.preventDefault();
        return false;
    }, false);
}

function make_map(x, y, b, mode, x0, y0) {
    /* general purpose builder */
    GAME._make_threads++;
    var options = {
        'x': x,
        'y': y,
        'n': (b ? b : x * y / 6),
        'mode': (mode ? mode : 'custom')
    };
    if (typeof x0 !== 'undefined' && typeof y0 !== 'undefined') {
        options.safeX = x0;
        options.safeY = y0;
        options.re = true;
    } else {
        options.re = false;
    }

    var _map = new MinesweeperMap(options);
    $12('#map').className = '';
    $12('#map').innerHTML = renderToHTML(_map);
    $12('#timer1').innerHTML = '0';

    GAME.map = _map;
    if (options.re) {
        GAME.map.clicks++;
        GAME.map.open('t-x' + options.safeX + 'y' + options.safeY, null);
    }
    GAME._make_threads--;
}

function make(modeName) {
    var _ms = GAME.modes;
    make_map(_ms[modeName].x, _ms[modeName].y, _ms[modeName].n, modeName);
}

function remake(modeName, x, y) {
    var _ms = GAME.modes;
    make_map(_ms[modeName].x, _ms[modeName].y, _ms[modeName].n, modeName, x, y);
}

function parseRecord(modeName) {
    var bestTime = Infinity;
    try {
        bestTime = GAME.storage['record-' + modeName] || Infinity;
    } catch (err) {

    }

    var medal = 'noob';
    switch (true) {
        case (bestTime < 1 * GAME.modes[modeName].t3):
            medal = 'gold';
            break;
        case (bestTime < 1 * GAME.modes[modeName].t2):
            medal = 'silver';
            break;
        case (bestTime < 1 * GAME.modes[modeName].t1):
            medal = 'bronze';
            break;
        default:
            bestTime = '';
            break;
    }
    $12('#' + modeName + ' span').className = medal;
    $12('#' + modeName + ' b').innerHTML = bestTime;
}

function init() {
    try {
        bakeGradients(); // and detect ancient browsers
        GAME.storage = window.localStorage;
        var ready = false;
        for (var i in GAME.modes) {
            parseRecord(i);
            (function (m) {
                $1(m).addEventListener('click', function () {
                    make(m);
                }, false);
            })(i);
            if (document.location.hash.replace('#', '') == i) {
                make(i);
                ready = true;
            }
        }
        if (!ready) {
            make('expert');
            document.location.hash = 'expert';
        }
        (function () {
            var bomb_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIDSURBVHja7JW/a9tAFMdPcmrXicGmVklIMKWlUON2KCEO7ZAhYyDeMmQJWT2ajKFzJy/9G1p389ShnYoJKSEkQwIZArFLIRkS/yAQtMhGev0+cw7iepKrwdChDz6cdLp77+57754MIhKTNFNM2P6tAIZh5MBapAh8BjoC7BM4Doqv8xfm/Cl44XPwCDjAA8/l+8hWwCudL0O3Wsgwg+ZCSvgBzINV8FIO+QXOQA10wVdwBfLw54yVSK6OHfOLzS2CUiwWI9k34hq48vljFIlYzzfgjuek02kqlUpUqVSoUCgMgymBmkELDjuDHR5vmiaVy2Xq9Xo0GAyoXq9TNptVA5yAhag7OOLxyWSSGo0GeZ5HbJ1Oh4rFohqAdV/nM1N9mcrhWqCOxwFY4j44Fu12+36MbdsCO1HzIg6+gG+Yn/J/mFIGPgQ/wS2wuKPf74tqtTpsLcsStVpNtFqtoHsyJ2mOyyLe2aFfBs6gRCIxPBNFnhFbLEKoRP7sBd/9Ha7rCsdxhpJpjHe9J+eJv7kHbDlwE7BalR8gpvMXVuzy4PGYUubKu/IabILUH1UhoFTE5Q1+AD6DafAWzMohnJan4ABkwDa4BIvw1w3LIn/avZOTd0EWPAP78tuGrx49AedgGfSilGudfO/lrdWZ9gyMKP9kSMc7zqgyhM75/9MfZ78FGADUwbryqz3ywAAAAABJRU5ErkJggg==';
            var st = document.createElement('style');
            var hh = '\n #map.defeat .bomb {	background-image: url(' + bomb_img + '); }';
            hh += 'noscript { display: none; }';
            st.innerHTML = hh;
            $12('head').appendChild(st);
            $12('link[rel="icon"]').href = bomb_img;
        })();
        (function () {
            $12('a[href*="getcli' + 'cky"]').title = "";
            $12('img[src*="getcli' + 'cky"]').alt = "";
        })();
        attachIO();

    } catch (err) {
        $1('old_browser').innerHTML = 'To play minesweeper you need a <a href="http://www.browserchoice.eu/">modern browser</a>.<br />';
    }
}


if (document.addEventListener) {
    document.addEventListener('DOMContentLoaded', init, false);
} else {
    GAME.slowpoke = true;
}