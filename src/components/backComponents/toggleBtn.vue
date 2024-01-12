<template>
    <div class="container" @click="updateItem">
        <div class="switch" :class="{ 'switch-on': item === '1', 'switch-off': item === '0' }">

            <input type="radio" :name="'select_onOff_' + index" v-model="localItem" value="0" :disabled="disabled">
            <input type="radio" :name="'select_onOff_' + index" v-model="localItem" value="1" :disabled="disabled">

            <label :for="'off_' + index">{{offText}}</label>
            <label :for="'on_' + index">{{onText}}</label>
            <span class="toggle" :class="{ 'toggle-on': item === '1' }"></span>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        item: String,
        index: Number,
        disabled: Boolean,
        onText:String,
        offText:String,  
    },
    data() {
        return {
            localItem: this.item,
        }
    },
    methods: {
        updateItem() {
            this.localItem = this.localItem === '1' ? '0' : '1';
            this.$emit('toggle', this.index, this.localItem);
            console.log('localItem', this.localItem);
            console.log('index', this.index);
        },
    },
};
</script>

<style scoped lang="scss">


.container {
    position: relative;
    width: 6rem;
    margin: auto;
    input:disabled{
        cursor: not-allowed;
    }
}

.switch {
    border-radius: 32px;
    height: 1.5rem;
    position: relative;
    width: 100%;
    margin: auto;
}

.switch-on {
    background-color: #5ec14f;
    label{
       
        &:nth-of-type(1){
            color: #ffffff;
        }
        &:nth-of-type(2){
            color: transparent;
        }
    }
    /* 上架背景色 */
}

.switch-off {
    background-color: #b5b5b5;
    /* 下架背景色 */
    label{
        &:nth-of-type(1){
            color: transparent;
        }
        &:nth-of-type(2){
            color: #fff;
        }
    }
}


.switch label {
    position: relative;
    z-index: 2;
    font-size: 14px;
    -webkit-transition: color .2s ease;
    -moz-transition: color .2s ease;
    -ms-transition: color .2s ease;
    -o-transition: color .2s ease;
    transition: color .2s ease;

}

.switch label:nth-of-type(1) {
    left: 5%;
    top: 2px;
    position: absolute;
    text-align: right;
}

.switch label:nth-of-type(2) {
    position: absolute; 
    right: 5%;
    top: 2px;
    text-align: left;
}

.switch input {
    height: 100%;
    left: 0;
    opacity: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 5;
    cursor: pointer;
}

.switch-off input:checked~.toggle {
    left: 3%;
}

.switch-on input~:checked~.toggle {
    left: 75%;
}

.toggle {
    background-color: #fff;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    border-radius: 50%;
    width: 19px;
    height: 19px;
    left: 3%;
    position: absolute;
    top: 2px;
    -webkit-transition: left .2s ease;
    -moz-transition: left .2s ease;
    -ms-transition: left .2s ease;
    -o-transition: left .2s ease;
    transition: left .2s ease;
    z-index: 1;
}
.toggle-on {
    left: 75%;
}
</style>