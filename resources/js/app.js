import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('followersTracker', (userId, followersCount, following) => ({
        FollowersCount: followersCount,
        following: following,
        follow(){
            this.following = !this.following;
            axios.post(`/follow/${userId}`)
            .then(response => {
                this.FollowersCount = response.data.followersCount;
                console.log(response.data);
            }).catch(error => {
                console.error(error);
            });
        }
    }));
});

Alpine.start();
