<!DOCTYPE html>
<?php session_start(); ?>

<head>
    <title>Mini-Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<script>
    class AABB {
        constructor(centerX, centerY, halfx, halfy) {
            this.centerX = centerX;
            this.centerY = centerY;
            this.halfx = halfx;
            this.halfy = halfy;
        }
        getHalfX() {
            return this.halfx;
        }
        getHalfY() {
            return this.halfy;
        }
        getCenterX() {
            return this.centerX;
        }
        setCenterX(x) {
            this.centerX = x;
        }
        getCenterY() {
            return this.centerY;
        }
        setCenterY(y) {
            this.centerY = y;
        }
        colliding(other) {
            var offsetX = Math.abs(this.centerX - other.getCenterX());
            var offsetY = Math.abs(this.centerY - other.getCenterY());
            if (offsetX > (this.halfx + other.getHalfX())) return false;
            if (offsetY > (this.halfy + other.getHalfY())) return false;
            return true;
        }
    }
</script>
<style>
    * {
        font-family: 'Press Start 2P', cursive;
        text-align: center;
    }

    body {
        background-color: #fafac8;
        color: #2a2a2a;
    }

    canvas {
        border: 1px solid white;
        image-rendering: pixelated;
        width: 512px;
        height: 512px;
        margin: auto;
        padding: 0;
        display: block;
        text-align: center;
    }
</style>

<body>
    <h1>Block Collector</h1>
    <div style="margin: auto;">
        <p>
        <h2>
            High Score: <span id="high_score">0</span> |
            Score: <span id="score">0</span>
            <br>
            Level: <span id="level">1</span>
        </h2>
        </p>
        <canvas id="glcanvas" class="border border-primary" width="256" height="256">Your browser may not support webGL, which is needed to run this Game.</canvas>
    </div>
    <sub style="color:#6a6a6a;">use WASD/arrow keys to move. Collect blocks to increase your score. Dont touch the Boundary!</sub>
    <?php
    if (!isset($_COOKIE['id'])) {
        echo '<div style="color:#6a6a6a">You are not logged in! Log in to get rewards while playing!</div>';
    }
    ?>
</body>
<script>
</script>

<script>
    let canvas = document.getElementById("glcanvas");
    const ctx = canvas.getContext("2d");
    let hscore = 0;
    let eh = decodeURIComponent(document.cookie).split(';');
    eh = eh.find(row => row.startsWith('hscore'));
    if (eh !== undefined) {
        hscore = Number(eh.split('=')[1]);
    }
    //let hscore = Number(decodeURIComponent(document.cookie).split(';').find(row => row.startsWith('hscore')).split('=')[1]);
    let score = 0;
    let player = {
        //player coordinates
        x: canvas.width / 2,
        y: canvas.height / 2,
        height: 32,
        width: 32,
        //player velocity
        dx: 0,
        dy: 0,
        AABB: new AABB(0, 0, 32 / 2, 32 / 2)
    }
    let movementX = 0;
    let movementY = 0;
    //this part of the code handles key presses
    let keyPressed = 0;
    document.addEventListener('keydown', function(e) {

        if (e.keyCode == ' '.charCodeAt(0)) { //spacebar
            //uhh todo...?
        } else if (e.keyCode == 'W'.charCodeAt(0) || e.keyCode == 38) { //W
            player.dy = movementY;
            keyPressed = 1;
        } else if (e.keyCode == 'A'.charCodeAt(0) || e.keyCode == 37) { //A
            player.dx = -movementX;
            keyPressed = 1;
        } else if (e.keyCode == 'D'.charCodeAt(0) || e.keyCode == 39) { //D
            player.dx = movementX;
            keyPressed = 1;
        } else if (e.keyCode == 'S'.charCodeAt(0) || e.keyCode == 40) { //S
            player.dy = -movementY;
            keyPressed = 1;
        }
        if (keyPressed === 1) e.preventDefault();
        keyPressed = 0;
    });
    document.addEventListener('keyup', function(e) {
        if (e.keyCode == ' '.charCodeAt(0)) { //spacebar

        } else if (e.keyCode == 'W'.charCodeAt(0) || e.keyCode == 38) { //W
            if (player.dy > 0) player.dy = 0;
        } else if (e.keyCode == 'A'.charCodeAt(0) || e.keyCode == 37) { //A
            if (player.dx < 0) player.dx = 0;
        } else if (e.keyCode == 'D'.charCodeAt(0) || e.keyCode == 39) { //D
            if (player.dx > 0) player.dx = 0;
        } else if (e.keyCode == 'S'.charCodeAt(0) || e.keyCode == 40) { //S
            if (player.dy < 0) player.dy = 0;
        }
    });

    function generateLoot() {
        //generate loot
        return new AABB(Math.floor(Math.random() * (canvas.width - 16 * 2) + 16), Math.floor(Math.random() * (canvas.height - 16 * 2) + 16), 1 + 16 / 2, 1 + 16 / 2);
        return lootAABB;
    }
    var loot = generateLoot();
    do {
        loot = generateLoot();
    } while (player.AABB.colliding(loot));

    function loop() {
        //clear the screen
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        if (player.AABB.colliding(loot)) {
            while (player.AABB.colliding(loot)) {
                loot = generateLoot();
            }
            if (hscore < ++score) {
                hscore = score;
                document.getElementById("high_score").innerHTML = hscore;
                <?php
                echo 'document.cookie = "hscore=" + hscore + ";" + "path=/";';
                ?>
            }
            document.getElementById("score").innerHTML = score;
        }
        movementX = (score / 10) + 2;
        movementY = (score / 10) + 2;
        document.getElementById("level").innerHTML = Math.floor(score / 10) + 1;
        ctx.fillStyle = "#FF0000";
        ctx.fillRect(loot.getCenterX() - 16 / 2, loot.getCenterY() - 16 / 2, 16, 16);
        //update the player
        player.x += player.dx;
        player.y -= player.dy; //subtract because y is inverted
        //check for collisions with map
        if (player.x < player.width / 2 || player.x > canvas.width - player.width / 2 ||
            player.y < player.height / 2 || player.y > canvas.height - player.height / 2) {
            //the player has collided with the map, rip
            score = 0;
            document.getElementById("score").innerHTML = score;
            player.x = canvas.width / 2;
            player.y = canvas.height / 2;
            player.dx = 0;
            player.dy = 0;
        }

        player.AABB.setCenterX(player.x);
        player.AABB.setCenterY(player.y);
        //draw the player
        ctx.fillStyle = "#008080";
        ctx.fillRect(player.x - player.width / 2, player.y - player.height / 2, player.width, player.height);

        //request another frame
        requestAnimationFrame(loop);
    }
    requestAnimationFrame(loop);
</script>