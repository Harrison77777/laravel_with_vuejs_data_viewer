<template>
    <div class="pagination-area pt-3">
        <nav class="page-area" aria-label="...">
            <ul class="pagination mx-auto">
                <li class="page-item " :class="{ disabled : pagination.current_page <= 1 } ">
                <a class="page-link" v-on:click.prevent="changePage(1)" href="#" >First</a>
                </li>

                <li class="page-item" :class="{ disabled : pagination.current_page <= 1 } ">
                <a class="page-link" href="#" v-on:click.prevent="changePage(pagination.current_page - 1)" >Previous</a>
                </li>

                <li v-for="(page, index) in pages" :class="{active: isCurrentPage(page) == true}" :key="index" class="page-item ">
                <a v-on:click.prevent="changePage(page)" class="page-link" href="#">{{page}}</a>
                </li>
                
                <li class="page-item" :class="{disabled: pagination.current_page >= pagination.last_page }">
                <a class="page-link" v-on:click.prevent="changePage(pagination.current_page + 1)" href="#">Next</a>
                </li>

                <li class="page-item" :class="{disabled : pagination.current_page >= pagination.last_page}">
                <a class="page-link" v-on:click.prevent="changePage(pagination.last_page)" href="#">Last</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: 'pagination',
    props: ['pagination', 'offset'],
    methods: {
        changePage(page){
            if (page > this.pagination.last_page) {
                page = this.pagination.last_page
            }
            this.pagination.current_page = page
            this.$emit('paginate')
        },
        isCurrentPage(page){
            return this.pagination.current_page === page
        }
    },
    computed: {
        pages(){
            let pages = []
            let from = this.pagination.current_page - Math.floor(this.offset / 2)
            if (from < 1) {
                from = 1
            }
            let to = from + this.offset - 1
            if (to > this.pagination.last_page) {
                to = this.pagination.last_page
            }
            while (from <= to) {
                pages.push(from)
                from++
            }
            return pages
        }
    },

}
</script>
 <style scoped>
     .pagination-area {
    display: flex;
    flex-direction: row;
    justify-content: center;
}
 </style>