@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('List of Friends') }}</div>

                <div class="card-body">
                <div class="form-group row">
                            <label for="search" class="col-md-4 col-form-label text-md-right">{{ __('Search by Name') }}</label>

                            <div class="col-md-6">
                            <input type="text" class="form-controller" id="serach" name="serach"></input>
                            </div>
                        </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('friend.pagination_data')
                        </tbody>
                    </table>
                    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection