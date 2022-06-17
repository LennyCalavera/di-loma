<link href="{{ mix('css/app.css') }}" rel="stylesheet">
<style>
    .body {
        color: #212529;
    }
    .container {
        margin-top: 50px;
        border-radius: 20px;
        padding: 10px;
        background: #E9E9E9;
    }
</style>


<div class="container text-center" style="width: 800px">
    <div class="card-header">
        <h2>Результат</h2>
    </div>

    @foreach($result as $diseaseData)
        <div class="card text-center" >
          <div class="card-header">
            <h4>{{ $diseaseData['DOT'] . '%' }}</h4>
          </div>
          <div class="card-body">
            <h4 class="title">{{ $diseaseData['name'] }}</h4>
          </div>
          <div class="card-footer text-muted">
            <a href="{{ $diseaseData['description'] }}" class="btn-sm btn-primary">Подробнее</a>
          </div>
        </div>
    @endforeach

      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
               <a href="{{ route('root') }}" class="btn btn-block btn-lg btn-primary">На главную</a>
            </div>
            <div class="col-sm-6">
                <div class="">
                    <a href="{{ route('searchInput') }}" class="btn btn-lg btn-block btn-primary">Новый поиск</a>
                </div>
            </div>
        </div>
      </div>
</div>