<div class="row">
    <div class="col-md-6">
        <h2>Browsers</h2>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Browser</th>
                <th>Hits</th>
                <th>Hosts</th>
                <th>Cookies</th>
            </tr>
            @foreach($browsers as $browser)
                <tr>
                    <td>{{$browser['name']}}</td>
                    <td>{{$browser['hits']}}</td>
                    <td>{{$browser['hosts']}}</td>
                    <td>{{$browser['cookies']}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="col-md-6">
        <h2>Operation systems</h2>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Operation system</th>
                <th>Hits</th>
                <th>Hosts</th>
                <th>Cookies</th>
            </tr>
            @foreach($OS as $os)
                <tr>
                    <td>{{$os['name']}}</td>
                    <td>{{$os['hits']}}</td>
                    <td>{{$os['hosts']}}</td>
                    <td>{{$os['cookies']}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h2>Regions</h2>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Region</th>
                <th>Hits</th>
                <th>Hosts</th>
                <th>Cookies</th>
            </tr>
            @foreach($regions as $region)
                <tr>
                    <td>{{$region['name']}}</td>
                    <td>{{$region['hits']}}</td>
                    <td>{{$region['hosts']}}</td>
                    <td>{{$region['cookies']}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="col-md-6">
        <h2>Referers</h2>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Referer</th>
                <th>Hits</th>
                <th>Hosts</th>
                <th>Cookies</th>
            </tr>
            @foreach($refs as $ref)
                <tr>
                    <td>{{$ref['name']}}</td>
                    <td>{{$ref['hits']}}</td>
                    <td>{{$ref['hosts']}}</td>
                    <td>{{$ref['cookies']}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>