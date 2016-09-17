 <table class="table table-striped zone-table">

                        <tbody>
                            <tr>
                                <th class="table-text">Zone Name</th>
                                <th class="table-text">Range</th>
                                <th class="table-text">&nbsp</th>
                                <th class="table-text">&nbsp</th>
                            </tr>

                            @foreach ($zones as $zone)
                                <tr>
                                    <!-- zone Name -->
                                    <td class="table-text">
                                        <div>{{ $zone->zone_name }}
                                            <button id="findzone" onclick="newLocation({{ $zone->latitude }},{{ $zone->longitude }},'{{ $zone->zone_name }}')">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td>
                                     <td class="table-text">
                                        <div>{{ $zone->range }}</div>
                                    </td>
                                    <td>
                                        <form action="editzone" method="get">
                  
                                            <input name="id" value="{{ $zone->id }}" type="hidden">

                                            <button type="submit" class="btn btn-info">
                                                <i class="glyphicon glyphicon-edit"></i> Edit
                                            </button>
                                        </form>
                                    </td>
                                     <!-- Delete Button -->
                                    <td>
                                        <form action="{{ url('zones/delete') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input name="id" value="{{ $zone->id }}" type="hidden">
                                             <input name="zonename" value="{{ $zone->zone_name }}" type="hidden">

                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        
                                    </td>
                                    
                                </tr>
                            @endforeach
                            </tbody>
                        </table>