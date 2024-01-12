<template>
    <!-- 右邊 -->
    <div class="test1"></div>
    <div class="test2"></div>
    <div class="test3"></div>

    <!-- 左邊 -->
    <div class="test4"></div>
    <div class="test5"></div>
    <div class="test6"></div>
</template>

  
<style scoped lang="scss">
.test1 {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 1.5px #1e4974 solid;
    animation: 5s paoPao infinite, 5s paoPao1 infinite linear;
    position: absolute;
    top: 65%;
    right: 30%;
}

.test2 {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: #1e4974;
    // border: 1.5px #1e4974 solid;
    animation: 4s paoPao infinite, 4s paoPao1 infinite linear;
    position: absolute;
    top: 60%;
    right: 35%;
}

.test3 {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    // background-color: #1e4974;
    border: 1.5px #1e4974 solid;
    animation: 3s paoPao infinite, 3s paoPao2 infinite linear;
    position: absolute;
    top: 80%;
    right: 33%;
}

.test4 {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    // background-color: #1e4974;
    border: 1.5px #1e4974 solid;
    animation: 5s paoPao infinite, 5s paoPao1 infinite linear;
    position: absolute;
    top: 60%;
    right: 65%;
}

.test5 {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: #1e4974;
    // border: 1.5px #1e4974 solid;
    animation: 4s paoPao infinite, 4s paoPao2 infinite linear;
    position: absolute;
    top: 75%;
    right: 67%;
}

.test6 {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    // background-color: #1e4974;
    border: 1.5px #1e4974 solid;
    animation: 3s paoPao infinite, 3s paoPao2 infinite linear;
    position: absolute;
    top: 90%;
    right: 63%;
}

@keyframes paoPao {
    0% {
        translate: 0;
        opacity: 0;
    }

    20% {
        opacity: 1;
    }

    100% {
        translate: 0 -150px;
        opacity: 0;
    }
}

@keyframes paoPao1 {
    0% {
        transform: translateX(0px);
    }

    25% {
        transform: translateX(15px);
    }

    50% {
        transform: translateX(7px);
    }

    75% {
        transform: translateX(10px);
    }

    100% {
        transform: translateX(5px);
    }
}

@keyframes paoPao2 {
    0% {
        transform: translateX(0px);
    }

    25% {
        transform: translateX(-15px);
    }

    50% {
        transform: translateX(-7px);
    }

    75% {
        transform: translateX(-10px);
    }

    100% {
        transform: translateX(-3px);
    }
}
</style>