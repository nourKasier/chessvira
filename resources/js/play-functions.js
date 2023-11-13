// NOTE: this uses the chess.js library:
// https://github.com/jhlywa/chess.js
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
var url = window.location.href;
var matchId = url.substring(url.lastIndexOf("/") + 1);
var board = null;
var game = new Chess();
var whiteSquareGrey = "#a9a9a9";
var blackSquareGrey = "#696969";
var $status = $("#status");
var $fen = $("#fen");
var $pgn = $("#pgn");
var gameTime = 600; //in seconds
var timer; // variable to hold the timer
var timeLeft = gameTime;
var timerStarted = false; // flag to indicate if the timer has started
var opponentTimer; // variable to hold the timer
var opponentTimeLeft = gameTime;
var opponentTimerStarted = false; // flag to indicate if the timer has started
var firstMoveMade = false;
var userColor = $("#chess-board").data("user-color"); // variable to store the user's color

if (userColor === "white" || userColor === "black") {
    sessionStorage.setItem("userColor", userColor);
}
if (userColor !== "white" && userColor !== "black") {
    userColor = sessionStorage.getItem("userColor");
}
var initialPosition = null; // Variable to store the initial position
// console.log("new startedd from resources");
console.log("User Color:", userColor);

startNewGame();

const channel = window.Echo.channel("chess-moves-" + matchId);
//to do : event for timers update
channel.listen("ChessMoveEvent", (event) => {
    console.log("Hhhhandle the event data and update the chessboard UI");
    // Handle the event data and update the chessboard UI
    // console.log("Haaandle the event data and update the chessboard UI:", event);
    // console.log(event.moveData);
    console.log("listen ChessMoveEvent: " + event.player1Time);
    console.log("listen ChessMoveEvent2: " + event.player2Time);
    //handle timers when a move is made
    if (userColor === "white") {
        timeLeft = event.player1Time;
        opponentTimeLeft = event.player2Time;
        if (event.moveData.color === "b") {
            startTimer();
            opponentPauseTimer();
        } else if (event.moveData.color === "w") {
            pauseTimer();
            opponentStartTimer();
        }
    } else if (userColor === "black") {
        timeLeft = event.player2Time;
        opponentTimeLeft = event.player1Time;
        if (event.moveData.color === "w") {
            startTimer();
            opponentPauseTimer();
        } else if (event.moveData.color === "b") {
            pauseTimer();
            opponentStartTimer();
        }
    }
    updateTimer();
    opponentUpdateTimer();

    game.move(event.moveData);
    board.position(game.fen());
    updateStatus();
});

window.Echo.join("chess-moves-" + matchId)
    .joining(() => {
        // A user is joining the channel
        $.ajax({
            type: "POST",
            url: "/set-players-times",
            contentType: "application/json",
            data: JSON.stringify({
                matchId: matchId,
                userColor: userColor,
                player1Time: timeLeft,
                player2Time: opponentTimeLeft,
            }),
            success: function (response) {
                console.log("set players-times.");
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.error("Error getting pgn: " + error);
            },
        });
        
        $.ajax({
            type: "POST",
            url: "/get-disconnection-time/" + matchId + "/" + userColor,
            contentType: "application/json",
            success: function (response) {
                console.log("get time diff while disconnect.");
                if (response.player1Time > 0 && response.player2Time > 0) {
                    console.log("whiteeeeee time diff while disconnect.");
                    console.log(response.player1Time);
                    console.log(response.player2Time);
                    setTimers(response.player1Time, response.player2Time);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.error("Error getting disconnection time: " + error);
            },
        });
        console.log("User joined:");
    })
    .here((users) => {
        if (users.length > 0) {
            // Users array contains at least one user
            // setTimersToStart();
            console.log("Users are present in the channel");
            // Perform the desired action for users present
        }
    })
    .leaving(() => {
        // A user is leaving the channel
        $.ajax({
            type: "POST",
            url: "/set-players-times",
            contentType: "application/json",
            data: JSON.stringify({
                matchId: matchId,
                userColor: userColor,
                player1Time: timeLeft,
                player2Time: opponentTimeLeft,
            }),
            success: function (response) {
                console.log("set players-times.");
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.error("Error getting pgn: " + error);
            },
        });
        $.ajax({
            type: "POST",
            url: "/set-disconnection-time/" + matchId + "/" + userColor,
            contentType: "application/json",
            success: function (response) {
                console.log("set disconnection.");
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.error("Error getting pgn: " + error);
            },
        });
        console.log("User left:");
    });

console.log("Subscribed to 'chess-moves-" + matchId + "' channel"); // Debug output

function startNewGame() {
    console.log("new game startedd");
    console.log("User Color:", userColor);
    // create new game
    // game = new Chess();

    // reset flags
    firstMoveMade = false;
    timerStarted = false;
    opponentTimerStarted = false;
    // reset timer
    resetTimer();
    opponentResetTimer();
    // update board
    // board.position(game.fen());

    // update status
    updateStatus();
}

function opponentStartTimer() {
    if (opponentTimerStarted === false) {
        opponentTimerStarted = true;
        opponentTimer = setInterval(function () {
            opponentTimeLeft--;
            var minutes = Math.floor(opponentTimeLeft / 60);
            var seconds = opponentTimeLeft % 60;
            if (opponentTimeLeft < 0) {
                clearInterval(opponentTimer);
                // alert("Time's up!");
                var opponentUserColor =
                    userColor === "white" ? "black" : "white";
                var status = "";
                status =
                    "Game over, " +
                    opponentUserColor +
                    "'s time is up, " +
                    opponentUserColor +
                    " has lost.";
                $status.html(status);
                var config = {
                    orientation: userColor,
                    draggable: false,
                    position: game.fen(),
                    onDragStart: onDragStart,
                    onDrop: onDrop,
                    onMouseoutSquare: onMouseoutSquare,
                    onMouseoverSquare: onMouseoverSquare,
                    onSnapEnd: onSnapEnd,
                };
                board = Chessboard("myBoard", config);
            } else {
                $("#opponent-timer").text(
                    minutes + ":" + (seconds < 10 ? "0" : "") + seconds
                );
                // $("#opponent-timer").text(opponentTimeLeft);
            }
        }, 1000);
    }
}
function startTimer() {
    if (timerStarted === false) {
        timerStarted = true;
        timer = setInterval(function () {
            timeLeft--;
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;
            if (timeLeft < 0) {
                clearInterval(timer);
                // alert("Time's up!");
                var status = "";
                status =
                    "Game over, " +
                    userColor +
                    "'s time is up, " +
                    userColor +
                    " has lost.";
                $status.html(status);
                var config = {
                    orientation: userColor,
                    draggable: false,
                    position: game.fen(),
                    onDragStart: onDragStart,
                    onDrop: onDrop,
                    onMouseoutSquare: onMouseoutSquare,
                    onMouseoverSquare: onMouseoverSquare,
                    onSnapEnd: onSnapEnd,
                };
                board = Chessboard("myBoard", config);
            } else {
                $("#timer").text(
                    minutes + ":" + (seconds < 10 ? "0" : "") + seconds
                );
                // $("#timer").text(timeLeft);
            }
        }, 1000);
    }
}
function opponentPauseTimer() {
    clearInterval(opponentTimer);
    opponentTimerStarted = false;
}
function pauseTimer() {
    clearInterval(timer);
    timerStarted = false;
}
function opponentResetTimer() {
    clearInterval(opponentTimer);
    opponentTimeLeft = gameTime;
    var minutes = Math.floor(opponentTimeLeft / 60);
    var seconds = opponentTimeLeft % 60;
    $("#opponent-timer").text(
        minutes + ":" + (seconds < 10 ? "0" : "") + seconds
    );
    // $("#opponent-timer").text(opponentTimeLeft);
}
function resetTimer() {
    clearInterval(timer);
    timeLeft = gameTime;
    var minutes = Math.floor(timeLeft / 60);
    var seconds = timeLeft % 60;
    $("#timer").text(minutes + ":" + (seconds < 10 ? "0" : "") + seconds);
    // $("#timer").text(timeLeft);
}
function opponentUpdateTimer() {
    // opponentTimeLeft += 5;
    var minutes = Math.floor(opponentTimeLeft / 60);
    var seconds = opponentTimeLeft % 60;
    $("#opponent-timer").text(
        minutes + ":" + (seconds < 10 ? "0" : "") + seconds
    );
    // $("#opponent-timer").text(opponentTimeLeft);
}
function updateTimer() {
    // timeLeft += 5;
    var minutes = Math.floor(timeLeft / 60);
    var seconds = timeLeft % 60;
    $("#timer").text(minutes + ":" + (seconds < 10 ? "0" : "") + seconds);
    // $("#timer").text(timeLeft);
}

function removeGreySquares() {
    $("#myBoard .square-55d63").css("background", "");
}

function greySquare(square) {
    var $square = $("#myBoard .square-" + square);

    var background = whiteSquareGrey;
    if ($square.hasClass("black-3c85d")) {
        background = blackSquareGrey;
    }

    $square.css("background", background);
}

function onDragStart(source, piece, position, orientation) {
    // do not pick up pieces if the game is over
    if (game.game_over()) return false;
    if (
        game.game_over() ||
        (userColor === "white" && game.turn() === "b") ||
        (userColor === "black" && game.turn() === "w")
    ) {
        return false;
    }
    // if (game.turn() === "b") return false;
    // only pick up pieces for the side to move
    if (
        (game.turn() === "w" && piece.search(/^b/) !== -1) ||
        (game.turn() === "b" && piece.search(/^w/) !== -1)
    ) {
        return false;
    }
}

function onDrop(source, target) {
    // see if the move is legal
    if (
        (userColor === "white" && game.turn() === "w") ||
        (userColor === "black" && game.turn() === "b")
    ) {
        var move = game.move({
            from: source,
            to: target,
            promotion: "q", // NOTE: always promote to a queen for example simplicity
        });
    }

    // illegal move
    if (move === null) {
        return "snapback";
    }
    // board.position(game.fen());
    // send move data to server
    $.ajax({
        type: "POST",
        url: "/store-move",
        data: JSON.stringify({
            move: move,
            pgn: game.pgn(),
            match_id: matchId,
            time_left: timeLeft,
            opponent_time_left: opponentTimeLeft,
        }),

        contentType: "application/json",
        success: function (response) {
            // console.log(move);
            console.log("Move saved successfully");
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.error("Error saving move: " + error);
        },
    });
    pauseTimer();
    updateStatus();

    if (!firstMoveMade) {
        // if this is the first move
        firstMoveMade = true; // set the flag to true
        return; // don't start the timer yet
    }
}

function onMouseoverSquare(square, piece) {
    // get list of possible moves for this square
    var moves = game.moves({
        square: square,
        verbose: true,
    });

    // exit if there are no moves available for this square
    if (moves.length === 0) return;

    // highlight the square they moused over
    greySquare(square);

    // highlight the possible squares for this piece
    for (var i = 0; i < moves.length; i++) {
        greySquare(moves[i].to);
    }
}

function onMouseoutSquare(square, piece) {
    removeGreySquares();
}

// update the board position after the piece snap
// for castling, en passant, pawn promotion
function onSnapEnd() {
    board.position(game.fen());
}

function updateStatus() {
    var status = "";

    var moveColor = "White";
    if (game.turn() === "b") {
        moveColor = "Black";
    }

    // checkmate?
    var game_is_over = false;
    if (game.in_checkmate()) {
        status = "Game over, " + moveColor + " is in checkmate.";
        game_is_over = true;
    }

    // draw?
    else if (game.in_draw()) {
        status = "Game over, drawn position";
        game_is_over = true;
    } else if (timeLeft < 0) {
        status =
            "Game over, " +
            UserColor +
            "'s time is up, " +
            UserColor +
            " has lost.";
        game_is_over = true;
    } else if (opponentTimeLeft < 0) {
        var opponentUserColor = userColor === "white" ? "black" : "white";
        status =
            "Game over, " +
            opponentUserColor +
            "'s time is up, " +
            opponentUserColor +
            " has lost.";
        game_is_over = true;
    }
    if (game_is_over === true) {
        pauseTimer();
        opponentPauseTimer();
    }
    // game still on
    else {
        status = moveColor + " to move";

        // check?
        if (game.in_check()) {
            status += ", " + moveColor + " is in check";
        }
    }

    $status.html(status);
    $fen.html(game.fen());
    $pgn.html(game.pgn());
}

var config = {
    orientation: userColor,
    draggable: false,
    position: "start",
    onDragStart: onDragStart,
    onDrop: onDrop,
    onMouseoutSquare: onMouseoutSquare,
    onMouseoverSquare: onMouseoverSquare,
    onSnapEnd: onSnapEnd,
};
board = Chessboard("myBoard", config);

// board.position("{{ $pgn }}");
updateStatus();

window.addEventListener("load", function () {
    loadSavedPosition();
    firstMoveMade = true;
});
// Handle the online event
function handleOnlineEvent() {
    loadSavedPosition();
}
// Load the saved position on the chessboard
function loadSavedPosition() {
    $.ajax({
        type: "POST",
        url: "/get-pgn/" + matchId,
        contentType: "application/json",
        success: function (response) {
            if (response.pgn != null) {
                game.load_pgn(response.pgn);
                board.position(game.fen());
                console.log("get pgn");
                console.log(game.turn());
                console.log(response.pgn);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.error("Error getting pgn: " + error);
        },
    });
}

function setTimers(player1Time, player2Time) {
    if (userColor === "white") {
        timeLeft = player1Time;
        opponentTimeLeft = player2Time;
    } else if (userColor === "black") {
        timeLeft = player2Time;
        opponentTimeLeft = player1Time;
    }
    setTimersToStart();
}

function setTimersToStart() {
    updateTimer();
    opponentUpdateTimer();
    if (userColor === "white") {
        if (game.turn() === "w") {
            startTimer();
            opponentPauseTimer();
        } else if (game.turn() === "b") {
            pauseTimer();
            opponentStartTimer();
        }
    } else if (userColor === "black") {
        if (game.turn() === "b") {
            startTimer();
            opponentPauseTimer();
        } else if (game.turn() === "w") {
            pauseTimer();
            opponentStartTimer();
        }
    }
}

window.onload = function () {
    // Prepare the data to be sent in the request body
    var data = {
        matchId: matchId,
        userColor: userColor,
        readiness: true,
    };

    // Make an AJAX request to update the readiness status using fetch
    fetch("/update-player-readiness", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        body: JSON.stringify(data),
    })
        .then(function (response) {
            if (response.ok) {
                console.log("Readiness updated successfully");
            } else {
                console.log("Failed to update readiness");
            }
        })
        .catch(function (error) {
            console.log("Error:", error);
        });

    function checkBothPlayersReady() {
        // Make an AJAX request to check if both players are ready
        fetch("/check-players-ready", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            body: JSON.stringify({ matchId: matchId }),
        })
            .then(function (response) {
                if (response.ok) {
                    response.json().then(function (data) {
                        if (data.playersReady) {
                            setTimersToStart(); // Call the function to start the timers
                            clearInterval(checkReady);
                            console.log("check readiness");
                            var config = {
                                orientation: userColor,
                                draggable: true,
                                position: game.fen(),
                                onDragStart: onDragStart,
                                onDrop: onDrop,
                                onMouseoutSquare: onMouseoutSquare,
                                onMouseoverSquare: onMouseoverSquare,
                                onSnapEnd: onSnapEnd,
                            };
                            board = Chessboard("myBoard", config);
                        } else {
                            // Players are not ready yet, you can handle this condition as needed
                            console.log("check readiness in false");
                        }
                    });
                } else {
                    console.log("Failed to check players readiness");
                }
            })
            .catch(function (error) {
                console.log("Error:", error);
            });
    }
    var checkReady = setInterval(checkBothPlayersReady, 2000);

    $.ajax({
        type: "POST",
        url: "/get-players-times",
        contentType: "application/json",
        data: JSON.stringify({ matchId: matchId }),
        success: function (response) {
            console.log("get players-times in onload.");
            if (response.player1Time !== gameTime) {
                console.log("get if players-times in onload.");
                setTimers(response.player1Time, response.player2Time);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.error("Error getting pgn: " + error);
        },
    });
};
