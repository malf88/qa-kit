<script setup lang="ts">

import {onMounted, ref} from "vue";
import {Sprint} from "../Interfaces/Sprint";

const props = defineProps({
    id: String,
    sprints:String ,
    selected: Number
});
const sprints = ref<Array<Sprint>>([])
const sprint_id = ref(props.selected);
onMounted(() => {
    sprints.value = JSON.parse(props.sprints);
})

</script>

<template>
    <select :id="props.id" v-model="sprint_id" :name="props.id" >
        <option v-for="sprint in sprints"
                :value="sprint.id">{{ sprint.nome }}</option>
    </select>
</template>

<style scoped>

</style>
