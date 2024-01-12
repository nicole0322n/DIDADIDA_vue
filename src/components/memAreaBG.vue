<template>
    <div class="deco_img deco_shark">
        <img src="../../public/all_images/deco/deco_shark.png" alt="">
    </div>
    <div class="deco_img deco_whale">
        <img src="../../public/all_images/deco/deco.whale.png" alt="">
    </div>
    <div class="deco_img deco_seastar">
        <img src="../../public/all_images/deco/deco_seastar.png" alt="">
    </div>
</template>

<style scoped lang="scss">
.deco_img {
    position: absolute;
    width: 170px;

    img {
        width: 100%;
    }
}

.deco_shark {
    top: -10px;
    right: 25px;
}

.deco_seastar {
    bottom: 155px;
    right: -50px;
}

.deco_whale {
    bottom: 30px;
    left: -5px;
}

@media screen and (max-width: 414px) {
    .deco_shark {
        top: -10px;
        right: -80px;

        img {
            width: 70%;
        }
    }

    .deco_whale {
        display: none;
    }

    .deco_seastar {
        bottom: -30px;
        right: 120px;

        img {
            width: 70%;
        }
    }
}
</style>