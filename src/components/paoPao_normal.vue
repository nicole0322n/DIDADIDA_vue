<template>
    <div class="test p1"></div>
    <div class="test p2"></div>
    <div class="test p3"></div>
</template>

  
<style scoped lang="scss">
.test {
    border-radius: 50%;
    border: 1.5px #1e4974 solid;
    position: absolute;
}

.test.p1 {
    width: 13px;
    height: 13px;
    animation: 4s paoPao infinite, 4s paoPao1 infinite linear;
    top: 73%;
}

.test.p2 {
    width: 10px;
    height: 10px;
    background-color: #1e4974;
    animation: 4s paoPao infinite, 4s paoPao2 infinite linear;
    top: 80%;
}

.test.p3 {
    width: 8px;
    height: 8px;
    animation: 4s paoPao infinite, 4s paoPao3 infinite linear;
    top: 85%;
}


@keyframes paoPao {
    0% {
        translate: 0;
        opacity: 0;
    }

    25% {
        opacity: 1;
    }

    100% {
        translate: 0 -100px;
        opacity: 0;
    }
}

@keyframes paoPao1 {
    0% {
        transform: translateX(0px);
    }

    20% {
        transform: translateX(13px);
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

@keyframes paoPao3 {
    0% {
        transform: translateX(0px);
    }

    25% {
        transform: translateX(3px);
    }

    50% {
        transform: translateX(10px);
    }

    75% {
        transform: translateX(5px);
    }

    100% {
        transform: translateX(10px);
    }
}
</style>