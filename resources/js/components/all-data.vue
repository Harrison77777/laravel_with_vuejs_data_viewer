<template>
    <div class="all-data-table-area pt-4">
        <div class="container">
            <div class="col-md-12">
                <div class="heading-area">
                    <h4>All Customer</h4>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="query-field-section">
                                    <select class=" form-control form-control-sm w-50" v-model="query" id="">
                                        <option value="name">Name</option>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="search-field-section">
                                    <input v-model="search" placeholder="Search" type="text"
                                        class="w-50 form-control form-control-sm ml-auto" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="button-area">
                                    <div class="row">
                                        <div class="col-md-12">
                                                
                                            <a v-on:click.prevent="refresh()"
                                                class="float-right mt-1 btn btn-sm ml-auto btn-primary"
                                                href="">Refresh</a>
                                            <button @click="editFalse()" type="button" data-toggle="modal" data-target="#customerModal"
                                                class="float-right mr-1 mt-1 btn btn-sm ml-auto btn-primary">
                                                Add Customer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="all-data-table table-responsive">
                            <table class="table table-sm table-hover table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        
                                        <th>Total Buy</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(customer, index) in customers" :key="customer.id" class="text-center">
                                        <td>{{ index +1 }}</td>
                                        <td>{{ customer.name }}</td>
                                        <td>{{ customer.email }}</td>
                                        <td>{{ customer.phone }}</td>
                                        <td>{{ customer.total_buy }}</td>
                                        <td>
                                            <a v-on:click.prevent="detailsCustomer(customer)" data-toggle="modal"
                                                data-target="#customerDetailsModal" class="btn btn-info btn-sm" href>
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a data-toggle="modal" data-target="#customerModal" @click="edit(customer)"  class="btn btn-primary btn-sm"
                                                href="#">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a v-on:click.prevent="deletecustomer(customer.id)" class="btn btn-danger btn-sm" href="#">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="py-3" v-if="customers.length == 0" colspan="6">
                                            <span class="alert text-danger d-block alert-sm alert-danger">
                                                Sorry :( No Found
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :pagination="pagination" v-if="pagination.last_page > 1" :offset="5"
                                @paginate="search === '' ? fetchAllCustomers() : searchCustomer()"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Add customer Modal -->
        <div class="modal add_customer_modal fade" id="customerModal" tabindex="-1" role="dialog"
            aria-labelledby="customerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customerModalLabel"><strong> {{editMode ? 'Edit  Customer Form' : 'Add New Customer Form'}}</strong> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent=" editMode == false ? addCustomer() : updateCustomer()">
                            <!-- <alert-errors :form="form"></alert-errors> -->
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" placeholder="Customer Name" name="name"
                                    class="form-control form-control-sm"
                                    :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="text" placeholder="Customer E-mail" name="email"
                                    class="form-control form-control-sm"
                                    :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input v-model="form.phone" placeholder="Customer Phone Number" type="text" name="phone"
                                    class="form-control form-control-sm"
                                    :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="phone"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <textarea placeholder="Customer Address" v-model="form.address" name="address"
                                    :class="{ 'is-invalid': form.errors.has('address') }"
                                    class="form-control form-control-sm" cols="15" rows="3">
                                    </textarea>
                                <has-error :form="form" field="phone"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input placeholder="Customer's Total Buy" v-model="form.total_buy" type="text"
                                    name="total_buy" class="form-control form-control-sm"
                                    :class="{ 'is-invalid': form.errors.has('total_buy') }">
                                <has-error :form="form" field="total_buy"></has-error>
                            </div>

                            <button :disabled="form.busy" type="submit" class="btn btn-primary btn-sm float-right">Save
                                Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add customer Modal End -->



        <!-- show details form Modal -->
        <div class="modal fade" id="customerDetailsModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <label class=" ml-3" for=""><strong>Name</strong></label>
                                    <input type="text" disabled v-model="CustomerName"
                                        class="w-75 ml-3 form-control form-control-sm" aria-describedby="helpId">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class=" ml-3" for=""><strong>E-mail</strong></label>
                                    <input type="text" disabled v-model="CustomerEmail"
                                        class="w-75 ml-3 form-control form-control-sm" aria-describedby="helpId">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class=" ml-3" for=""><strong>Phone</strong></label>
                                    <input type="text" disabled v-model="CustomerPhone"
                                        class="w-75 ml-3 form-control form-control-sm" aria-describedby="helpId">
                                </div>
                                <div class="row">
                                    <label class=" ml-3" for=""><strong>Address</strong></label>
                                    <textarea v-model="CustomerAddress" class="w-75 ml-1 form-control form-control-sm"
                                        disabled cols="15" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <label class=" ml-3" for=""><strong>Total Buy</strong></label>
                                    <input type="text" disabled v-model="CustomerTotalBuy"
                                        class="w-75 ml-1 mt-2 form-control form-control-sm" aria-describedby="helpId">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
           
        </div>
        <vue-progress-bar></vue-progress-bar>
        <vue-snotify></vue-snotify>
    </div>
</template>
<script>
    export default {
        name: "all-data",
        data() {
            return {
                editMode: false,
                customers: [],
                pagination: {
                    current_page: 1
                },
                query: 'name',
                search: '',
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    phone: '',
                    address: '',
                    total_buy: '',
                }),

                CustomerName: "",
                CustomerEmail: "",
                CustomerPhone: "",
                CustomerAddress: "",
                CustomerTotalBuy : "",

            };
        },
        watch: {
            search: function (newQuery, oldQuery) {
                if (newQuery === '') {
                    this.fetchAllCustomers()
                } else {
                    this.searchCustomer()
                }
            }
        },
        mounted() {
            this.fetchAllCustomers()
        },
        methods: {
            fetchAllCustomers() {
                this.$Progress.start()
                axios.get("/api/all/customers?page=" + this.pagination.current_page)
                    .then(res => {
                        this.customers = res.data.data
                        this.pagination = res.data.meta
                        this.$Progress.finish()
                    })
                    .catch(err => {
                        console.log(err);
                        this.$Progress.fail()
                    });
            },
            searchCustomer() {
                this.$Progress.start()
                axios.get('/api/search/customer/' + this.query + '/' + this.search + '?page=' + this.pagination.current_page)
                    .then(res => {
                        this.customers = res.data.data
                        this.pagination = res.data.meta
                        this.$Progress.finish()
                    }).catch(err => {
                        console.log(err);
                        this.$Progress.fail()

                    })
            },
            refresh() {
                this.fetchAllCustomers()
                this.search = ""
                this.query = "name"
                this.$snotify.success('Successfully page reloaded :)', 'Success')
            },
            addCustomer() {
                this.$Progress.start()
                this.form.post('/api/add/customer')
                    .then(res => {
                        if (this.form.successful) {
                            $('#customerModal').modal('hide')
                            this.customers.unshift(res.data)
                            this.$Progress.finish()
                            this.$snotify.success('Customer added Successfully :)', 'Success')
                            this.form.name = ''
                            this.form.email = ''
                            this.form.phone = ''
                            this.form.address = ''
                            this.form.total_buy = ''
                        }
                        

                    }).catch(err => {
                        console.log(err);
                        this.$Progress.fail()
                    })
            },
            detailsCustomer(customer) {
                this.CustomerName = customer.name
                this.CustomerEmail = customer.email
                this.CustomerAddress = customer.address
                this.CustomerPhone = customer.phone
                this.CustomerTotalBuy = customer.total_buy
            },

            deletecustomer(customerId){
                this.$Progress.start()
                this.customers = this.customers.filter(customer => {
                    return customer.id != customerId
                })
                axios.delete('api/delete/customer/'+customerId)
                .then(res => {
                    this.$snotify.success(res.data.successMsg, 'Success')
                    this.$Progress.finish()
                    console.log(res);
                    
                }).catch(err => {
                    console.log(err); 
                    this.$Progress.fail()
                })     
            },
            
            edit(customer){
                 this.editMode = true
                 this.form.reset();
                 this.form.clear();
                this.form.fill(customer)
            },
            editFalse(){
                this.editMode = false
               
                this.form.reset();
                 this.form.clear();
            },
            updateCustomer(){
                this.form.busy = true
                this.$Progress.start()
               this.form.put('/api/update/customer/'+this.form.id)
               .then(res => {
                   if (this.form.successful) {
                    this.fetchAllCustomers() 
                    this.$snotify.success(res.data.successMsg, 'Success')
                   this.$Progress.finish()
                   $('#customerModal').modal('hide')
                   }
                   
               }).catch(err => {
                   console.log(err);
                   this.$Progress.fail()
               }) 
            }
        },

        computed: {

        }
    };
</script>