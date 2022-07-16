<template>
    <div class="mx-2">
        <i @click="handleOrderChange('asc')" v-show="order=='desc'" class="bi bi-arrow-up-circle-fill ordering-icon" title="Növekvő sorrend"></i>
        <i @click="handleOrderChange('desc')" v-show="order=='asc'" class="bi bi-arrow-down-circle-fill ordering-icon" title="Csökkenő sorrend"></i>
    </div>
</template>

<script>
export default {
    props: ['value'],
    data(){
        return{
            order: this.value
        }
    },
    methods:{
        handleOrderChange(order){
            this.order=order
            this.$emit('input', this.order)
        }
    }
}
</script>
