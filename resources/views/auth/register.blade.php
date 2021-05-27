@extends('layouts.auth')

@section('content')
<div class="page-content page-auth" id="register">
            <div class="section-store-auth" data-aos="fade-up">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <h2>
                                Memulai untuk iklan barangmu <br />
                                bersama Thriftkuy
                            </h2>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input id="name" 
                                    v-model="name"
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    autocomplete="name" 
                                    autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="email" 
                                    v-model="email"
                                    @change="checkForEmailAvailability()"
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror"
                                    :class="{ 'is-invalid': this.email_unavailable }"
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="password" 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror 
                                    "name="password" 
                                    required 
                                    autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input id="password-confirm" 
                                    type="password" 
                                    class="form-control @error('password_confirmation') is-invalid @enderror 
                                    "name="password_confirmation" 
                                    required 
                                    autocomplete="new-password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                        <div class="form-group">
                            <label>Store</label>
                            <p class="text-muted">
                                Apakah kamu juga ingin iklan barang kamu?
                            </p>
                            <div
                            class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    name="is_store_open"
                                    id="openStoreTrue"
                                    v-model="is_store_open"
                                    :value="true"
                                />
                                <label for="openStoreTrue" class="custom-control-label">
                                    Iya
                                </label>
                            </div>
                            <div
                                class="custom-control custom-radio custom-control-inline"
                            >
                                <input
                                    type="radio"
                                    class="custom-control-input"
                                    name="is_store_open"
                                    id="openStoreFalse"
                                    v-model="is_store_open"
                                    :value="false"
                                />
                                <label for="openStoreFalse" class="custom-control-label">
                                    Tidak
                                </label>
                            </div>
                        </div>
                        <div class="form-group" v-if="is_store_open">
                                    <label>Nama Toko</label>
                                    <input
                                type="text" 
                                v-model="store_name"
                                id="store_name"  
                                class="form-control @error('store_name') is-invalid @enderror" 
                                name="store_name" 
                                value="{{ old('store_name') }}" 
                                required 
                                autocomplete="store_name" 
                                autofocus>
                            @error('store_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                </div>
                                <div class="form-group" v-if="is_store_open">
                                    <label>Kategori</label>
                                    <select name="categories_id" class="form-control">
                                <option value="" disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                                </div>
                                                <div class="form-group">
                            <label class="text-danger">Ketentuan</label>
                            <p class="text-muted">
                                <ol  style="text-align: justify;">Pengguna Thriftkuy diharap untuk memberi informasi kondisi barang yang ditawarkan secara lengkap.</ol>
                                <ol  style="text-align: justify;">Pengguna Thriftkuy diharap untuk mencantumkan kontak secara jelas.</ol>
                                <ol  style="text-align: justify;">Demi keamanan, transaksi lebih diutamakan via COD atau REKBER.</ol>
                                <ol  style="text-align: justify;">Akun Pengguna akan dinonaktifkan ketika terdapat pelanggaran</ol>
                                <ol  style="text-align: justify;">Kontak layanan: thriftkuy@gmail.com | 0838-123-4567</ol>
                            </p>
                            
                            </div>
                        </div>
                                <button
                            type="submit"
                            class="btn btn-success btn-block mt-4"
                            :disabled="this.email_unavailable"
                            >
                            Sign Up
                        </button>
                        <a href="{{ route('login') }}" class="btn btn-signup btn-block mt-2">
                            Kembali ke Sign In
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
            Vue.use(Toasted);

            var register = new Vue({
                el: "#register",
                mounted() {
                    AOS.init();
                },
                methods: {
                    checkForEmailAvailability: function () {
                        var self = this;
                        axios.get('{{ route('api-register-check') }}', {
                            params: {
                                email: this.email
                                }
                                })
                    .then(function (response) {
                        if(response.data == 'Available') {
                            self.$toasted.show(
                                "Email anda tersedia! Silahkan lanjut langkah selanjutnya!", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 1000,
                                }
                            );
                            self.email_unavailable = false;
                        } else {
                            self.$toasted.error(
                                "Maaf, tampaknya email sudah terdaftar pada sistem kami.", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 1000,
                                }
                            );
                            self.email_unavailable = true;
                        }
                        // handle success
                        console.log(response.data);
                    })
            }
        },
                data() {
                    return {
                    name: "nama kamu",
                    email: "emailkamu@mail.com",
                    is_store_open: true,
                    store_name: "",
                    email_unavailable: false
                    }
                },
            });
    </script>
@endpush