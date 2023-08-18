<script setup>
import {onMounted} from "vue";
import { ref } from "vue"
import {GGanttChart, GGanttRow} from "@infectoone/vue-ganttastic";

const row1BarList = ref([
    {
        myBeginDate: "2021-07-13 13:00",
        myEndDate: "2021-07-13 19:00",
        ganttBarConfig: {
            // each bar must have a nested ganttBarConfig object ...
            id: "unique-id-1", // ... and a unique "id" property
            label: "Lorem ipsum dolor"
        }
    },
    {
        myBeginDate: "2021-07-15 13:00",
        myEndDate: "2021-07-15 19:00",
        ganttBarConfig: {
            // each bar must have a nested ganttBarConfig object ...
            id: "unique-id-1", // ... and a unique "id" property
            label: "Lorem ipsum dolor"
        }
    }

])
const row2BarList = ref([
    {
        myBeginDate: "2021-07-13 00:00",
        myEndDate: "2021-07-14 02:00",
        ganttBarConfig: {
            id: "another-unique-id-2",
            hasHandles: true,
            label: "Hey, look at me",
            style: {
                // arbitrary CSS styling for your bar
                background: "#e09b69",
                borderRadius: "20px",
                color: "black"
            }
        }
    }
])
</script>

<template>
    <div class="container">

    </div>
</template>

