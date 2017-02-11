@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/record.css">
@endsection

@section('content')
    <div class="col-md-11 col-md-offset-1">
        <section id="knockout-table" class="clearfix">
            @foreach($roundsRecords as $roundRecords)
                <div class="column">
                    @foreach($roundRecords as $record)
                        <p class="game @if($record->round->is_finished and $record->canUserSeeResult()) comp-done @endif">
                            @foreach($record->teams as $team)
                                <span class="team-name team-{{ $loop->iteration }}
                                    @if($record->winner_id == $team->id) winner @elseif($team->has_lost) loser @endif">
                                    {{ $team->name }}
                                </span>
                            @endforeach
                            <a href="/record/{{$record->id}}" class="show-result">result</a>
                        </p>
                    @endforeach
                </div>
            @endforeach
        </section>
    </div>
@endsection
