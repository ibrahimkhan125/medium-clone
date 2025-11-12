import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {

    // Global helper for formatting numbers
    Alpine.magic('short', () => (num) => {
        if (num >= 1e9) return (num / 1e9).toFixed(1).replace(/\.0$/, '') + 'B';
        if (num >= 1e6) return (num / 1e6).toFixed(1).replace(/\.0$/, '') + 'M';
        if (num >= 1e3) return (num / 1e3).toFixed(1).replace(/\.0$/, '') + 'K';
        return num;
    });

    Alpine.data('followersTracker', (userId, followersCount, following, clapCount, postId) => ({
        followersCount: followersCount,
        following: following,
        clapCount: clapCount,
        async follow(){
            this.following = !this.following;
            await axios.post(`/follow/${userId}`)
            .then(response => {
                this.followersCount = response.data.followersCount;
                console.log(response.data);
            }).catch(error => {
                console.error(error);
            });
        },
        // async clapCounter(){
        //     try {
        //         const response = await axios.post(`/clap/${userId}/${postId}`)
        //         this.clapCount = response.data.count;
        //     }
        //     catch (error) {
        //         console.error(error);
        //     }
        // },
        formattedClapCount() {
            return this.$short(this.clapCount);
        }
    }));
    Alpine.data('userClapping', (opts = {}) => ({
        hasClapped: opts.hasClapped,
        postClapCount: opts.postClapCount ?? 0,
        postId: opts.postId ?? null,
        async userClap(){
            try{
                const response = await axios.post(`/clap/${this.postId}`);
                console.log(response.data, 'response data');
                this.postClapCount = response.data.count;
                this.hasClapped = !this.hasClapped;
            }catch(error){
                console.error(error);
            }
        }
    }));
});
// function checkCase(str) {
//     return str[0] === str[0].toUpperCase() ? "upper case" : "lower case";
// }
// console.log(checkCase("Dello")); // Output: upper case

Alpine.start();
