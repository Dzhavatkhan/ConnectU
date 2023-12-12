<template>
    <div>
        <h2>
            {{ user.name}}
        </h2>
        <div class="" v-if="friends == 0">
            {{ friends }}
        </div>
        <div v-else>
            {{ friends }}
        </div>
        <div v-if="isFriend == 0">
            <button @click="addFriend(user.id)">Добавить в друзья</button>
        </div>
        <div v-else>
            <p>У вас в друзьях</p>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

let user = ref([])
let friends = ref([])
let isFriend = ref([])
let props = defineProps({
    id: {
        type:String,
        default: ''
    }
})
onMounted( async() => [
    getUser()
])

const getUser = async() => {
    let response  = await axios.get(`/api/user/id${props.id}`)
    user.value = response.data.user[0]
    friends = response.data.friends
    isFriend = response.data.isFriend;
    console.log(response.data.isFriend);
}
const addFriend = async(id) => {
    alert(id);
    let response = await axios.post('/api/addFriend', {
        user_id: id
    })
    .then((result) => {
        console.log(result.data);
        getUser();
    }).catch((err) => {
        console.log(err);
    });
}

</script>

<style scoped>

</style>
