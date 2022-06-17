<head>
    <title>{{ env('APP_NAME') }}</title>
  <link href="https://netdna.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>

<style>
  body {
    padding-top: 50px;
    padding-bottom: 50px;
}

.price-box {
    margin: 0 auto;
	background: #E9E9E9;
	border-radius: 10px;
	padding: 10px 15px;
	width: 700px;
}

.ui-widget-content {
	border: 1px solid #bdc3c7;
	background: #e1e1e1;
	color: #222222;
	margin-top: 4px;
}

.ui-slider .ui-slider-handle {
	position: absolute;
	z-index: 2;
	width: 5.2em;
	height: 2.2em;
	cursor: default;
	margin: 0 -40px auto !important;
	text-align: center;
	line-height: 30px;
	color: #FFFFFF;
	font-size: 15px;
}

.ui-slider .ui-slider-handle .glyphicon {
	color: #FFFFFF;
	margin: 0 3px;
	font-size: 11px;
	opacity: 0.5;
}

.ui-corner-all {
	border-radius: 20px;
}

.ui-slider-horizontal .ui-slider-handle {
	top: -.9em;
}

.ui-state-default,
.ui-widget-content .ui-state-default {
	border: 1px solid #f9f9f9;
	background: #0069d9;
}

.ui-slider-horizontal .ui-slider-handle {
	margin-left: -0.5em;
}

.ui-slider .ui-slider-handle {
	cursor: pointer;
}

.ui-slider a,
.ui-slider a:focus {
	cursor: pointer;
	outline: none;
}

.price, .lead p {
	font-weight: 600;
	font-size: 32px;
	display: inline-block;
	line-height: 60px;
}

h4.great {
	background: #007bff;
	margin: 0 0 25px;
	padding: 7px 15px;
	color: #ffffff;
	font-size: 18px;
	font-weight: 600;
	border-radius: 5px;
	display: inline-block;
	-moz-box-shadow:    2px 4px 5px 0 #ccc;
  	-webkit-box-shadow: 2px 4px 5px 0 #ccc;
  	box-shadow:         2px 4px 5px 0 #ccc;
}

.total {
	border-bottom: 1px solid #7f8c8d;
	/*display: inline;
	padding: 10px 5px;*/
	position: relative;
	padding-bottom: 20px;
}

.total:before {
	content: "";
	display: inline;
	position: absolute;
	left: 0;
	bottom: 5px;
	width: 100%;
	height: 3px;
	background: #7f8c8d;
	opacity: 0.5;
}

.price-slider {
	margin-bottom: 70px;
}

.price-slider span {
	font-weight: 200;
	display: inline-block;
	color: #7f8c8d;
	font-size: 13px;
    margin: 0 0 0 5px;
}

.form-pricing {
	background: #ffffff;
	padding: 20px;
	border-radius: 4px;
}

.price-form {
	background: #ffffff;
	margin-bottom: 10px;
	padding: 20px;
	border: 1px solid #eeeeee;
	border-radius: 4px;
	/*-moz-box-shadow:    0 5px 5px 0 #ccc;
  	-webkit-box-shadow: 0 5px 5px 0 #ccc;
  	box-shadow:         0 5px 5px 0 #ccc;*/
}

.form-group {
	margin-bottom: 0;
}

.form-group span.price {
	font-weight: 200;
	display: inline-block;
	color: #7f8c8d;
	font-size: 14px;
}

.help-text {
	display: block;
	margin-top: 32px;
	margin-bottom: 10px;
	color: #737373;
	position: absolute;
	/*margin-left: 20px;*/
	font-weight: 200;
	text-align: right;
	width: 188px;
}

.price-form label {
	font-weight: 200;
	font-size: 21px;
}

img.payment {
	display: block;
    margin-left: auto;
    margin-right: auto
}
.ui-slider {
	background: #2980b9 !important;
}

/* HR */

hr.style {
	margin-top: 0;
    border: 0;
    border-bottom: 1px dashed #ccc;
    background: #999;
}
</style>

<script>
  $("#YourElementID").css({ display: "block" });
  $(document).ready(function() {
    @foreach($data['symptoms'] as $id => $symptom)
          $("#slider{{ $id }}").slider({
              animate: true,
              value:1,
              min: {{ (int) $symptom['minBorder'] }},
              max: {{ (int) $symptom['maxBorder'] }},
              step: {{ ($symptom['maxBorder'] - $symptom['minBorder']) / 100 }},
              slide: function(event, ui) {
                  update({{ $id }}, ui.value); //changed
              }
          });
          update({{ $id }}, {{ $symptom['minBorder'] }});
    @endforeach()
  });

  function addSymptom()
  {
    var val = $("#selectedOption").val();
    $("#symptomItem" + val).css("display","block");
  }

  function check(id)
  {
      $("#selectedOption").val(id - 1);
  }

  function deleteSymptom(id)
  {
    $("#symptomItem" + id).css("display","none");
  }

  function update(id,val)
  {
    $("#input" + id).val(val);
    $('#slider' + id + ' a').html('<label><span class="glyphicon glyphicon-chevron-left"></span> ' + val + ' <span class="glyphicon glyphicon-chevron-right"></span></label>');
  }
</script>
</head>
    <div class="container">

      <div class="price-box">
        <h3>Укажите симптомы:</h3>
        <input id="selectedOption" type="hidden">
        <form method="GET" action="{{ route('searchResult') }}" class="form-horizontal form-pricing" role="form">
          @foreach($data['symptoms'] as $id => $symptom)
            <input name="{{ $symptom['name'] }}" id="input{{ $id }}" style="display: none" type="text" value="{{ $symptom['minBorder'] }}">

            <div style="display:none" id="symptomItem{{ $id }}" class="price-slider">
              <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-lg-10">
                       <h4 class="great">{{ $symptom['name'] }}</h4>
                        <span>
                            от {{ $symptom['minBorder'] }} до {{ $symptom['maxBorder'] }}.
                        </span>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-outline-danger float-right" type="button" onclick="deleteSymptom({{ $id }})">Удалить</button>
                    </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div id="slider{{ $id }}"></div>
              </div>
            </div>
          @endforeach
          <div class="price-form">
              <div class="input-group">
                  <select class="custom-select" id="symptomSelect" onclick="if (typeof(this.selectedIndex) != 'undefined') check(this.selectedIndex)">
                    <option selected>Выберите симптом</option>
                    @foreach($data['symptoms'] as $id => $symptom)
                      <option>{{ $symptom['name'] }}</option>
                    @endforeach
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn-outline-success" type="button" onclick="addSymptom()">Добавить</button>
                  </div>
              </div>
          </div>
          <div class="form-group">
              <button type="submit" class="btn btn-primary btn-lg btn-block">Начать поиск <span class="glyphicon glyphicon-chevron-right pull-right" style="padding-right: 10px;"></span></button>
          </div>
      </form>
    </div>
</div>
