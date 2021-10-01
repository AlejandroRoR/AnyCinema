@extends('backend.layouts.app')

@section('title')
    {{ __('Planes de Pago') }}
@endsection

@section('page-head')
    {{ __('Planes de Pago') }}
@endsection

@section('content')
<div class="col-md-12">
    <a href="{{ route('admin.prices') }}" class="btn btn-info mb-4">{{ __('Volver') }}</a>
    <div class="card">
        <form action="{{ route('admin.prices.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <h4 class="card-title">{{ __('Crear Plan') }}</h4>
                <hr>

                <div class="form-group row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Nombre') }}</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ old('name') }}"
                            name="name">
                        @error('name')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Precio') }}</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ old('price') }}"
                            name="price">
                        @error('price')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group divdias row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Lunes') }}</label>
                    <div class="col-sm-4">
                        <input type="checkbox" class="form-check-input indias" name="lunes" value="1"
                            {{ old('lunes') == '1' ? 'checked' : '' }}>
                        @error('lunes')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group divdias row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Martes') }}</label>
                    <div class="col-sm-4">
                        <input type="checkbox" class="form-check-input indias" name="martes" value="1"
                            {{ old('martes') == '1' ? 'checked' : '' }}>
                        @error('martes')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group divdias row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Miercoles') }}</label>
                    <div class="col-sm-4">
                        <input type="checkbox" class="form-check-input indias" name="miercoles" value="1"
                            {{ old('miercoles') == '1' ? 'checked' : '' }}>
                        @error('miercoles')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group divdias row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Jueves') }}</label>
                    <div class="col-sm-4">
                        <input type="checkbox" class="form-check-input indias" name="jueves"  value="1"
                            {{ old('jueves') == '1' ? 'checked' : '' }}>
                        @error('jueves')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group divdias row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Viernes') }}</label>
                    <div class="col-sm-4">
                        <input type="checkbox" class="form-check-input indias"  name="viernes"  value="1"
                            {{ old('viernes') == '1' ? 'checked' : '' }}>
                        @error('viernes')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group divdias row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Sabado') }}</label>
                    <div class="col-sm-4">
                        <input type="checkbox" class="form-check-input indias" name="sabado"  value="1"
                            {{ old('sabado') == '1' ? 'checked' : '' }}>
                        @error('sabado')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group divdias row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Domingo') }}</label>
                    <div class="col-sm-4">
                        <input type="checkbox" class="form-check-input indias" name="domingo"  value="1"
                            {{ old('domingo') == '1' ? 'checked' : '' }}>
                        @error('domingo')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group divfecha row">
                    <label for="fname"
                        class="col-sm-4 text-end control-label col-form-label">{{ __('Fecha') }}</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="fecha" id="infecha" placeholder="dd/mm/yyyy"
                            value="{{ old('fecha') }}">
                        @error('fecha')
                            <small class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success text-white">{{ __('Crear Plan') }}</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
    
@endsection

@section('script')
    <script>
        $(() => {
            $('#infecha').on('change', compruebaFecha); 
            $('.indias').on('change', compruebaDias); 
        })

        // Comprueba si la hay alguna fecha y esconde los checkbox
        function compruebaFecha(){
            if($(this).val() === ""){
                $(".divdias").show();
            } else{
                $(".divdias").hide();
                
            }
        }

        // Comprueba si algun checkbox esta marcado y esconde la fecha
        function compruebaDias(){
            if($(".indias").is(':checked')){
                $(".divfecha").hide();
            } else{
                $(".divfecha").show();
            }
        }

    </script>
@endsection