<h1>Statistic</h1>
<table>

</table>
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="#hits" role="tab" id="hits-tab" data-toggle="tab">Hits</a></li>
    <li role="presentation"><a href="#hosts" role="tab" id="hosts-tab" data-toggle="tab">Unique Hosts</a></li>
    <li role="presentation"><a href="#cookies" role="tab" id="hosts-tab" data-toggle="tab">Unique Cookie</a></li>
</ul>
<div class="tab-content">
    <div id="hits" class="tab-pane fade active in" role="tabpanel">
        <table class="table table-bordered table-striped sorted">
            <thead>
            <tr>
                <th>Browser</th>
                <th>OS</th>
                <th>Host</th>
                <th>Country</th>
                <th>Region</th>
                <th>City</th>
                <th>Hit</th>
                <th>Referer</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{$client->browser}}</td>
                    <td>{{$client->os}}</td>
                    <td>{{$client->host}}</td>
                    <td>{{$client->location['country']}}</td>
                    <td>{{$client->location['region']}}</td>
                    <td>{{$client->location['city']}}</td>
                    <td>{{$client->url}}</td>
                    <td>{{$client->referer}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <table class="table">
            <tr>
                <td>Total views:</td>
                <td>{{$hits_count}}</td>
            </tr>
        </table>
    </div>
    <div id="hosts" class="tab-pane fade" role="tabpanel">
        <table class="table table-bordered table-striped sorted">
            <thead>
            <tr>
                <th>Browser</th>
                <th>OS</th>
                <th>Host</th>
                <th>Country</th>
                <th>Region</th>
                <th>City</th>
                <th>Hit</th>
                <th>Referer</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hosts as $client)
                <tr>
                    <td>{{$client->browser}}</td>
                    <td>{{$client->os}}</td>
                    <td>{{$client->host}}</td>
                    <td>{{$client->location['country']}}</td>
                    <td>{{$client->location['region']}}</td>
                    <td>{{$client->location['city']}}</td>
                    <td>{{$client->url}}</td>
                    <td>{{$client->referer}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <table class="table">
            <tr>
                <td>Total unique views:</td>
                <td>{{$hosts_count}}</td>
            </tr>
        </table>
    </div>
    <div id="cookies" class="tab-pane fade" role="tabpanel">
        <table class="table table-bordered table-striped sorted">
            <thead>
            <tr>
                <th>Browser</th>
                <th>OS</th>
                <th>Host</th>
                <th>Country</th>
                <th>Region</th>
                <th>City</th>
                <th>Hit</th>
                <th>Referer</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cookies as $client)
                <tr>
                    <td>{{$client->browser}}</td>
                    <td>{{$client->os}}</td>
                    <td>{{$client->host}}</td>
                    <td>{{$client->location['country']}}</td>
                    <td>{{$client->location['region']}}</td>
                    <td>{{$client->location['city']}}</td>
                    <td>{{$client->url}}</td>
                    <td>{{$client->referer}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <table class="table">
            <tr>
                <td>Total unique views:</td>
                <td>{{$hosts_count}}</td>
            </tr>
        </table>
    </div>
</div>

<script>
    $(function(){

    })
</script>