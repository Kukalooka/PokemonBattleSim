document.addEventListener("DOMContentLoaded", function(){
    let enemy = document.querySelector("#enemy");
    let player = document.querySelector("#player");

    let battletext = document.querySelector("#battltext");

    let level = Number(document.querySelector(".playerlv").innerHTML);

    console.log(level);

    let enemyLv = Number(document.querySelector(".lvl").innerHTML);

    console.log(enemyLv);

    let button1 = document.querySelector("#button1");
    let button2 = document.querySelector("#button2");
    let button3 = document.querySelector("#button3");
    let button4 = document.querySelector("#button4");

    let yes = document.querySelector("#yes");
    let no = document.querySelector("#no");

    let enemyId = Number(document.querySelector(".enemy").innerHTML);

    let enemyStatus;
    let enemyHPs = [];
    
    let playerParty = [];
    let playerHPs = [];

    let switurn = false;

    let pokeslot1 = document.querySelector("#pokeslot1");
    let pokeslot2 = document.querySelector("#pokeslot2");
    let pokeslot3 = document.querySelector("#pokeslot3");

    playerParty.push(Number(document.querySelector(".slot1").innerHTML));
    playerParty.push(Number(document.querySelector(".slot2").innerHTML));
    playerParty.push(Number(document.querySelector(".slot3").innerHTML));

    let playerPartySprite = [];

    playerPartySprite.push(document.querySelector(".sprite1").innerHTML);
    playerPartySprite.push(document.querySelector(".sprite2").innerHTML);
    playerPartySprite.push(document.querySelector(".sprite3").innerHTML);

    pokeslot1.src = "Sprites/PokeIcons/" + playerParty[0] + ".png";
    pokeslot2.src = "Sprites/PokeIcons/" + playerParty[1] + ".png";
    if(playerParty[1] == -1) { pokeslot2.style.display = "none"; }
    pokeslot3.src = "Sprites/PokeIcons/" + playerParty[2] + ".png";
    if(playerParty[2] == -1) { pokeslot3.style.display = "none"; }

    for(let i = 0; i < 3; i++){
        if(playerParty[i] != -1){
            playerHPs.push(Math.floor(0.01 * (2 * pokemon[playerParty[i]].hp) * level) + level + 10);
            
        }
    }

    let playerPartyId = 0;
    let playerId = playerParty[playerPartyId];

    let playerStatus;

    enemy.src = "Sprites/PokeFront/" + document.querySelector(".enemysprite").innerHTML + ".png";
    player.src = "Sprites/Pokeback/" + playerPartySprite[0] + ".png";

    document.querySelector("#staPlayer > span").innerHTML = pokemon[playerId].name;
    document.querySelector("#staEnemy > span").innerHTML = pokemon[enemyId].name;

    button1.innerHTML = moves[pokemon[playerId].moves[0].move1].name;
    button2.innerHTML = moves[pokemon[playerId].moves[0].move2].name;
    button3.innerHTML = moves[pokemon[playerId].moves[0].move3].name;
    button4.innerHTML = moves[pokemon[playerId].moves[0].move4].name;

    let choice;
    let turnOver = true;

    let EnemyMaxHP;
    let EnemyHP;
    let EnemyAttack;
    let EnemyAtkMod;
    let EnemyDefense;
    let EnemyDefMod;
    let EnemySpeed;
    let EnemySpeMod;

    let PlayerMaxHP;
    let PlayerHP;
    let PlayerAttack;
    let PlayerAtkMod;
    let PlayerDefense;
    let PlayerDefMod;
    let PlayerSpeed;
    let PlayerSpeMod;

    let playerBar = document.querySelector("#staPlayer > #hpbar > #hpgreen");
    let enemyBar = document.querySelector("#staEnemy > #hpbar > #hpgreen");

    function swi(who, what){
        if(who == "player"){
            playerId = playerParty[what];
            PlayerMaxHP = Math.floor(0.01 * (2 * pokemon[playerId].hp) * level) + level + 10;
            PlayerHP = playerHPs[what];
            PlayerAttack = Math.floor(0.01 * (2 * pokemon[playerId].attack) * level) + 5;
            PlayerAtkMod = 1;
            PlayerDefense = Math.floor(0.01 * (2 * pokemon[playerId].defense) * level) + 5;
            PlayerDefMod = 1;
            PlayerSpeed = Math.floor(0.01 * (2 * pokemon[playerId].speed) * level) + 5;
            PlayerSpeMod = 1;
            playerStatus = "";

            button1.innerHTML = moves[pokemon[playerId].moves[0].move1].name;
            button2.innerHTML = moves[pokemon[playerId].moves[0].move2].name;
            button3.innerHTML = moves[pokemon[playerId].moves[0].move3].name;
            button4.innerHTML = moves[pokemon[playerId].moves[0].move4].name;

            playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
            enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";
            
            console.log(playerId);
            document.querySelector("#staPlayer > span").innerHTML = pokemon[playerId].name;
            player.src = "Sprites/Pokeback/" + playerPartySprite[what] + ".png";
        }
        if(who == "enemy"){
            EnemyMaxHP =  Math.floor(0.01 * (2 * pokemon[enemyId].hp) * enemyLv) + enemyLv + 10;
            EnemyHP = EnemyMaxHP;
            EnemyAttack = Math.floor(0.01 * (2 * pokemon[enemyId].attack) * enemyLv) + 5;
            EnemyAtkMod = 1;
            EnemyDefense = Math.floor(0.01 * (2 * pokemon[enemyId].defense) * enemyLv) + 5;
            EnemyDefMod = 1;
            EnemySpeed = Math.floor(0.01 * (2 * pokemon[enemyId].speed) * enemyLv) + 5;
            EnemySpeMod = 1;
            enemyStatus = "";

            playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
            enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";

            document.querySelector("#staEnemy > span").innerHTML = pokemon[enemyId].name;
            enemy.src = "Sprites/PokeFront/" + document.querySelector(".enemysprite").innerHTML + ".png";
        }
    }

    swi("player", 0);
    swi("enemy", 0);

    playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
    enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";

    function attack(who, attackId){
        if(who == "player"){
            let category = moves[attackId].category;

            switch(category){
               case "damage":
                   EnemyHP -= (((((2 * level) / 5 + 2) * moves[attackId].damage * PlayerAttack / PlayerDefense) / 50 + 2)) * PlayerAtkMod / EnemyDefMod;
                   if(EnemyHP < 0)
                        EnemyHP = 0;
                   break;
                case "stat":
                    let target = moves[attackId].target;
                    let stat = moves[attackId].stat;
                    if(target == "enemy"){
                        switch(stat){
                            case "attack":
                                if(EnemyAtkMod >= 0.40){
                                    if(moves[attackId].stage == 1){
                                        EnemyAtkMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        EnemyAtkMod -= 0.30;
                                    }
                                }
                                break;
                            case "defense":
                                if(EnemyDefMod >= 0.40){
                                    if(moves[attackId].stage == 1){
                                        EnemyDefMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        EnemyDefMod -= 0.30;
                                    }
                                }
                                break;
                            case "speed":
                                if(EnemySpeMod >= 0.40){
                                    if(moves[attackId].stage == 1){
                                        EnemySpeMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        EnemySpeMod -= 0.30;
                                    }
                                }
                                break;
                        }
                    }
                    else{
                        switch(stat){
                            case "attack":
                                if(PlayerAtkMod < 2){
                                    if(moves[attackId].stage == 1){
                                        PlayerAtkMod += 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        PlayerAtkMod += 0.30;
                                    }
                                }
                                break;
                            case "defense":
                                if(PlayerDefMod < 2){
                                    if(moves[attackId].stage == 1){
                                        PlayerDefMod += 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        PlayerDefMod += 0.30;
                                    }
                                }
                                break;
                            case "speed":
                                if(PlayerSpeMod < 2){
                                    if(moves[attackId].stage == 1){
                                        PlayerSpeMod += 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        PlayerSpeMod += 0.30;
                                    }
                                }
                                break;
                        }

                    }
                    break;
                case "status":
                    enemyStatus = moves[attackId].status;
                    if(enemyStatus == "burn")
                        EnemyAttack = EnemyAttack / 2;
                    break;
            }
        }

        if(who == "enemy"){
            let category = moves[attackId].category;

            console.log(category);
            console.log(attackId);

            switch(category){
               case "damage":
                   PlayerHP -= (((((2 * enemyLv) / 5 + 2) * moves[attackId].damage * EnemyAttack / PlayerDefense) / 50 + 2)) * EnemyAtkMod / PlayerDefMod;
                   if(PlayerHP < 0)
                    PlayerHP = 0;
                   break;
                case "stat":
                    let target = moves[attackId].target;
                    let stat = moves[attackId].stat;
                    if(target == "enemy"){
                        switch(stat){
                            case "attack":
                                if(PlayerAtkMod >= 0.40){
                                    if(moves[attackId].stage == 1){
                                        PlayerAtkMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        PlayerAtkMod -= 0.30;
                                    }
                                }
                                break;
                            case "defense":
                                if(PlayerDefMod >= 0.40){
                                    if(moves[attackId].stage == 1){
                                        PlayerDefMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        PlayerDefMod -= 0.30;
                                    }
                                }
                                break;
                            case "speed":
                                if(PlayerSpeMod >= 0.40){
                                    if(moves[attackId].stage == 1){
                                        PlayerSpeMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        PlayerSpeMod -= 0.30;
                                    }
                                }
                                break;
                        }
                        
                    }
                    else{
                        switch(stat){
                            case "attack":
                                if(EnemyAtkMod < 2){
                                    if(moves[attackId].stage == 1){
                                        EnemyAtkMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        EnemyAtkMod -= 0.30;
                                    }
                                }
                                break;
                            case "defense":
                                if(EnemyDefMod < 2){
                                    if(moves[attackId].stage == 1){
                                        EnemyDefMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        EnemyDefMod -= 0.30;
                                    }
                                }
                                break;
                            case "speed":
                                if(EnemySpeMod < 2){
                                    if(moves[attackId].stage == 1){
                                        EnemySpeMod -= 0.20;
                                    }
                                    
                                    if(moves[attackId].stage == 2){
                                        EnemySpeMod -= 0.30;
                                    }
                                }
                                break;
                        }
                    }
                    break;
                case "status":
                    playerStatus = moves[attackId].status;
                    if(playerStatus == "burn")
                        PlayerAttack = PlayerAttack / 2;
                    break;
            }
        }
        
        playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
        enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";
    }

    function effCheck(moveType, TargetType){
        let multiplier;

        switch(moveType){
            case fire:
                switch(TargetType){
                    case grass:
                        multiplier = 2;
                        break;
                }
                break;
        }

        return multiplier;
    }

    function randomMove(){
        EnChoice = Math.floor((Math.random() * 4) + 1);

        switch(EnChoice){
            case 1:
                return pokemon[enemyId].moves[0].move1;
                break;
            case 2:
                return pokemon[enemyId].moves[0].move2;
                break;
            case 3: 
                return pokemon[enemyId].moves[0].move3;
                break;
            case 4:
                return pokemon[enemyId].moves[0].move4;
                break;
        }
    }
    
    function turn(choice){

        console.log("click");

        if(switurn == true){
            playerHPs[playerPartyId] = PlayerHP;
            playerPartyId = choice;
            console.log(choice);
            swi("player", choice);
        }

        if(PlayerSpeed * PlayerSpeMod > EnemySpeed * EnemySpeMod){
            if(switurn == false){
                battletext.innerHTML = pokemon[playerId].name + " użył " + moves[choice].name;
                attack("player", choice);

                console.log("Op1");
                
                playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
                enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";

            }

            setTimeout(function(){
                if(EnemyHP > 0){
                    los = randomMove()
                    battletext.innerHTML = pokemon[enemyId].name + " użył " + moves[los].name;
                    attack("enemy", los);
                    playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
                    enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";
                    console.log(PlayerHP);
                }
            }, 2000)
        }
        else{
            los = randomMove()
            battletext.innerHTML = pokemon[enemyId].name + " użył " + moves[los].name;
            attack("enemy", los);
            
            console.log("Op2");

            playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
            enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";

            setTimeout(function(){
                if(PlayerHP > 0){
                    if(switurn == false){
                        battletext.innerHTML = pokemon[playerId].name + " użył " + moves[choice].name;
                        attack("player", choice);
                    }
                    playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
                    enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";
                    console.log(PlayerHP);
                }
            }, 2000)
        }



        setTimeout(function(){
            if(PlayerHP > 0){
                if(playerStatus == "burn" || playerStatus == "poison"){
                
                    battletext.innerHTML = pokemon[playerId].name + " jest skrzywdzony przez " + playerStatus;
                    PlayerHP -= PlayerMaxHP / 16;
                    playerBar.style.width = PlayerHP / PlayerMaxHP * 100 + "%";
                
                }
            }
        }, 4000)

        setTimeout(function(){
            if(EnemyHP > 0){
                if(enemyStatus == "burn" || enemyStatus == "poison"){
                
                    battletext.innerHTML = pokemon[enemyId].name + " jest skrzywdzony przez " + enemyStatus;
                    EnemyHP -= EnemyMaxHP / 16;
                    enemyBar.style.width = EnemyHP / EnemyMaxHP * 100 + "%";
                
                }
            }
        }, 5000)


        console.log(PlayerHP);
        console.log(EnemyHP);

        console.log(EnemyDefMod);

        setTimeout(function(){
            switurn = false;

            if(PlayerHP != 0 && EnemyHP != 0){
                turnOver = true;
            }

            if(PlayerHP <= 0){
                battletext.innerHTML = pokemon[playerId].name + " upadł..."

                playerHPs[playerPartyId] = 0;

                console.log(playerHPs[playerPartyId]);

                let flag = false;

                for(let i = 0; i < 3; i++){
                    if(Number.isNaN(playerParty[i]) == false){
                        if(playerHPs[i] > 0){
                            if(flag == false){
                                battletext.innerHTML += " Wybierz innego Pokemona do walki";
                            }
                            flag = true;
                            console.log(PlayerHP + "" + "Chicken butt " + flag );
                            turnOver = true;
                        }
                        else{
                            if(i == 2){
                                if(flag == false){
                                    battletext.innerHTML += " Przegrałeś...";
                                }
                            }
                        }
                    }
                }

                
            }

            if(EnemyHP <= 0){

                battletext.innerHTML = "Dziki " + pokemon[enemyId].name + " upadł... Czy chcesz go złapać?"

                document.querySelector("#moves").style.display = "none";
                document.querySelector("#catch").style.display = "block";
                yes.style.display = "inline-flex";
                no.style.display = "inline-flex";
            }


        }, 5100);
    }

    button1.addEventListener("click", function(){
        if(PlayerHP > 0){
            if(turnOver == true){
                turnOver = false;
                choice = pokemon[playerId].moves[0].move1;
                turn(choice);
            }
        }
    });

    button2.addEventListener("click", function(){
        if(PlayerHP > 0){
            if(turnOver == true){
                turnOver = false;
                choice = pokemon[playerId].moves[0].move2;
                turn(choice);
            }
        }
    });
    
    button3.addEventListener("click", function(){
        if(PlayerHP > 0){
            if(turnOver == true){
                turnOver = false;
                choice = pokemon[playerId].moves[0].move3;
                turn(choice);
            }
        }
    });

    button4.addEventListener("click", function(){
        if(PlayerHP > 0){
            if(turnOver == true){
                turnOver = false;
                choice = pokemon[playerId].moves[0].move4;
                turn(choice);
            }
        }
    });

    pokeslot1.addEventListener("click", function(){
        if(playerHPs[0] > 0){
            if(turnOver == true){
                if(playerPartyId != 0){
                    turnOver = false;
                    switurn = true;
                    turn(0);
                }
            }
        }
    });

    pokeslot2.addEventListener("click", function(){
        if(playerHPs[1] > 0){
            if(turnOver == true){
                turnOver = false;
                if(playerPartyId != 1){
                    switurn = true;
                    turn(1);
                }
            }
        }
    });

    pokeslot3.addEventListener("click", function(){
        if(playerHPs[2] > 0){
            if(turnOver == true){
                turnOver = false;
                if(playerPartyId != 2){
                    switurn = true;
                    turn(2);
                }
            }
        }
    });

    yes.addEventListener("click", function(){
        window.open("catch.php", "_self");
    });

    no.addEventListener("click", function(){
        window.open("run.php", "_self");
    });
     
});