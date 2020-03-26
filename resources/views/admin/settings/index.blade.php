@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-header-title">
                            Настройки
                        </h4>
                    </div>
                </div>
            </div> 

            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Время автоматического завершения сессии, мин.</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="20">
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

