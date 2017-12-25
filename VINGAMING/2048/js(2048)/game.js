var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var sizeInput = document.getElementById('size');
var changeSize = document.getElementById('cSize');
var scoreLabel = document.getElementById('score');
var score = 0;
var r = 15;
var radius = 15;
var size = 4;
var width = canvas.width / size;
var cells = [];
var fontSize;
var loss = false;
var win = false;
var c = 5;
var o = 5;

start();

function start() {
    if (sizeInput.value >= 2 && sizeInput.value <= 7) {
        size = sizeInput.value;
        o = c * 2 / Math.sqrt(size);
        radius = r * 2 / Math.sqrt(size);
        width = canvas.width / size - 2 * o / size;
        console.log(sizeInput.value);
        canvasClean();
        startGame();
    }
}

function roundedRect(x, y) {
    var rect = canvas.getContext('2d');
    ctx.beginPath();
    var a = width;
    rect.moveTo(x + o, y + radius + o);
    rect.lineTo(x + o, y + a - radius - o);
    rect.quadraticCurveTo(x + o, y + a - o, x + radius + o, y + a - o);
    rect.lineTo(x + a - radius - o, y + a - o);
    rect.quadraticCurveTo(x + a - o, y + a - o, x + a - o, y + a - radius - o);
    rect.lineTo(x + a - o, y + radius + o);
    rect.quadraticCurveTo(x + a - o, y + o, x + a - radius - o, y + o);
    rect.lineTo(x + o + radius, y + o);
    rect.quadraticCurveTo(x + o, y + o, x + o, y + radius + o);
    return rect;
}

function cell(row, coll) {
    this.value = 0;
    this.x = coll * width + o;
    this.y = row * width + o;
}

function createCells() {
    var i, j;
    for (i = 0; i < size; i++) {
        cells[i] = [];
        for (j = 0; j < size; j++) {
            cells[i][j] = new cell(i, j);
        }
    }
}

function drawCell(cell) {
    ctx = roundedRect(cell.x, cell.y);
    var i=0;
    switch (cell.value) {
        case 0 :
            ctx.fillStyle = '#cbc0b5';
            break;
        case 2 :
            ctx.fillStyle = '#ede2d7';
            break;
        case 4 :
            ctx.fillStyle = '#edddca';
            break;
        case 8 :
            ctx.fillStyle = '#ffbf00';
            break;
        case 16 :
            ctx.fillStyle = '#bfff00';
            break;
        case 32 :
            ctx.fillStyle = '#40ff00';
            break;
        case 64 :
            ctx.fillStyle = '#00bfff';
            break;
        case 128 :
            ctx.fillStyle = '#FF7F50';
            break;
        case 256 :
            ctx.fillStyle = '#0040ff';
            break;
        case 512 :
            ctx.fillStyle = '#ff0080';
            break;
        case 1024 :
            ctx.fillStyle = '#D2691E';
            break;
        case 2048 :
            ctx.fillStyle = '#FF7F50';
            i++;
            break;
        case 4096 :
            ctx.fillStyle = '#ffbf00';
            break;
        default :
            ctx.fillStyle = '#ff0080';
    }
    ctx.fill();
    if (cell.value) {
        fontSize = width / 2;
        ctx.font = fontSize + 'px Arial';
        ctx.fillStyle = 'white';
        ctx.textAlign = 'center';
        ctx.fillText(cell.value, cell.x + width / 2, cell.y + width / 2 + width / 7);
    }
    return i;
}

function canvasClean() {
    ctx.clearRect(0, 0, 500, 500);
}

document.onkeydown = function (event) {
    if (!loss) {
        if (event.keyCode === 38 || event.keyCode === 87) {
            moveUp();
        } else if (event.keyCode === 39 || event.keyCode === 68) {
            moveRight();
        } else if (event.keyCode === 40 || event.keyCode === 83) {
            moveDown();
        } else if (event.keyCode === 37 || event.keyCode === 65) {
            moveLeft();
        }
        scoreLabel.innerHTML = 'Score : ' + score;
    }
}

function startGame() {
    loss = false;
    canvas.style.opacity = 1;
    createCells();
    drawAllCells();
    pasteNewCell();
    pasteNewCell();
}

function finishGame() {
    canvas.style.opacity = '0.5';
    if (win) {
        alert("Вы победили");
        $.ajax({
            type: "post",
            url: "../php_include/saveStatistic.php",
            data: "type=victory2048",
            dataType: "html",
            cache: false,
            success: function (data) {
            }
        });
    } else {
        if (loss) {
            alert("Вы проиграли");
            $.ajax({
                type: "post",
                url: "../php_include/saveStatistic.php",
                data: "type=loose2048",
                dataType: "html",
                cache: false,
                success: function (data) {
                }
            });
        }
    }
    win = false;
    loss = false;
}

function drawAllCells() {
    var i, j;
    var sum=0;
    for (i = 0; i < size; i++) {
        for (j = 0; j < size; j++) {
            sum+=drawCell(cells[i][j]);
        }
    }
    if(sum>0){
        win=true;
        finishGame();
    }
}

function pasteNewCell() {
    var countFree = 0;
    var i, j;
    for (i = 0; i < size; i++) {
        for (j = 0; j < size; j++) {
            if (!cells[i][j].value) {
                countFree++;
            }
        }
    }
    if (!countFree) {
        loss = true;
        finishGame();
        return;
    }
    while (true) {
        var row = Math.floor(Math.random() * size);
        var coll = Math.floor(Math.random() * size);
        if (!cells[row][coll].value) {
            cells[row][coll].value = 2 * Math.ceil(Math.random() * 2);
            canvasClean();
            drawAllCells();
            return;
        }
    }
}

function moveRight() {
    var i, j;
    var coll;
    for (i = 0; i < size; i++) {
        for (j = size - 2; j >= 0; j--) {
            if (cells[i][j].value) {
                coll = j;
                while (coll + 1 < size) {
                    if (!cells[i][coll + 1].value) {
                        cells[i][coll + 1].value = cells[i][coll].value;
                        cells[i][coll].value = 0;
                        coll++;
                    } else if (cells[i][coll].value == cells[i][coll + 1].value) {
                        cells[i][coll + 1].value *= 2;
                        score += cells[i][coll + 1].value;
                        cells[i][coll].value = 0;
                        break;
                    } else {
                        break;
                    }
                }
            }
        }
    }
    pasteNewCell();
}

function moveLeft() {
    var i, j;
    var coll;
    for (i = 0; i < size; i++) {
        for (j = 1; j < size; j++) {
            if (cells[i][j].value) {
                coll = j;
                while (coll - 1 >= 0) {
                    if (!cells[i][coll - 1].value) {
                        cells[i][coll - 1].value = cells[i][coll].value;
                        cells[i][coll].value = 0;
                        coll--;
                    } else if (cells[i][coll].value == cells[i][coll - 1].value) {
                        cells[i][coll - 1].value *= 2;
                        score += cells[i][coll - 1].value;
                        cells[i][coll].value = 0;
                        break;
                    } else {
                        break;
                    }
                }
            }
        }
    }
    pasteNewCell();
}

function moveUp() {
    var i, j, row;
    for (j = 0; j < size; j++) {
        for (i = 1; i < size; i++) {
            if (cells[i][j].value) {
                row = i;
                while (row > 0) {
                    if (!cells[row - 1][j].value) {
                        cells[row - 1][j].value = cells[row][j].value;
                        cells[row][j].value = 0;
                        row--;
                    } else if (cells[row][j].value == cells[row - 1][j].value) {
                        cells[row - 1][j].value *= 2;
                        score += cells[row - 1][j].value;
                        cells[row][j].value = 0;
                        break;
                    } else {
                        break;
                    }
                }
            }
        }
    }
    pasteNewCell();
}

function moveDown() {
    var i, j, row;
    for (j = 0; j < size; j++) {
        for (i = size - 2; i >= 0; i--) {
            if (cells[i][j].value) {
                row = i;
                while (row + 1 < size) {
                    if (!cells[row + 1][j].value) {
                        cells[row + 1][j].value = cells[row][j].value;
                        cells[row][j].value = 0;
                        row++;
                    } else if (cells[row][j].value == cells[row + 1][j].value) {
                        cells[row + 1][j].value *= 2;
                        score += cells[row + 1][j].value;
                        cells[row][j].value = 0;
                        break;
                    } else {
                        break;
                    }
                }
            }
        }
    }
    pasteNewCell();
}
