<?php

namespace App\Http\Controllers;

use App\Incentives\Core\Entity;
use App\Incentives\Rules\Goal;
use App\Incentives\Rules\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EntitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = Entity::orderBy('name')->paginate(10);

        return view('entities.index', compact('entities'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incentives\Core\Entity $entity
     * @return \Illuminate\Http\Response
     */
    public function show(Entity $entity)
    {
        $results = [];
        $points = [];
        $entity->makeHidden('rules');
        foreach ($entity->rules as $rule) {
            $points[] = [
                'created_at' => $rule->pivot->created_at->toDateTimeString(),
                'points' => $rule->pivot->points,
                'value' => $rule->pivot->value,
                'description' => $rule->pivot->description,
            ];
        }
        $entity->points = $points;
        $results['entity'] = $entity;

        return $results;
    }

    /**
     * Display the specified resource.
     *
     * @param $identification
     * @return \Illuminate\Http\Response
     */
    public function showByIdentification($identification)
    {
        $results = [];
        if ($entity = Entity::where('identification', $identification)->first()) {
            $points = [];
            $entity->makeHidden('rules');
            foreach ($entity->rules as $rule) {
                $points[] = [
                    'id' => $rule->pivot->id,
                    'created_at' => $rule->pivot->created_at->toDateTimeString(),
                    'points' => $rule->pivot->points,
                    'value' => $rule->pivot->value,
                    'description' => $rule->pivot->description,
                    'rule_id' => $rule->id
                ];
            }
            $entity->points = $points;
            $results['entity'] = $entity;
        } else {
            $results['status'] = 'error';
            $results['message'] = __('No existe la entidad');
        }

        return $results;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incentives\Core\Entity $entity
     * @return \Illuminate\Http\Response
     */
    public function edit(Entity $entity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Incentives\Core\Entity $entity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entity $entity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incentives\Core\Entity $entity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entity $entity)
    {
        //
    }

    /**
     * Adds rule value to given entity
     * @param $identification
     * @return array
     */
    public function addvalue($identification)
    {
        $this->validate(request(), [
            'rule' => 'required|exists:rules,id',
        ]);
        $results = [];
        $entity = Entity::firstOrCreate(['identification' => $identification]);

        if ($rule = Rule::find(request()->get('rule'))) {
            $value = request()->get('value', 1);
            $description = request()->get('description');
            $ids = $entity->rules()->pluck('entity_rule.id')->toArray();

            $entity->rules()->attach($rule->id, ['value' => $value, 'points' => $value * $rule->points, 'description' => $description]);
            foreach ($entity->rules as $val) {
                if (!in_array($val->pivot->id, $ids)) $rvalue = $val->pivot;
            }
            $results['value'] = $rvalue;
        }
        $results['entity'] = $entity;

        return $results;
    }

    /**
     * Adds goal value to given entity
     * @param $identification
     * @return array
     */
    public function addgoalvalue($identification)
    {
        $this->validate(request(), [
            'goal' => 'required|exists:goals,id',
        ]);
        $results = [];
        $entity = Entity::firstOrCreate(['identification' => $identification]);
        $results['entity'] = $entity;

        if ($goal = Goal::find(request()->get('goal'))) {
            $value = request()->get('value', 1);
            $date = request()->get('date', Carbon::now()->toDateString());
            if($gvalue = $entity->goals()->wherePivot('date', $date)->where('goals.id',$goal->id)->first()){
                $results['value'] = $gvalue;
                $entity->goals()->wherePivot('date', $date)->updateExistingPivot($goal->id, ['value'=>$value]);
            } else {
                $ids = $entity->goals()->pluck('entity_goal.id')->toArray();
                $entity->goals()->attach($goal->id, ['value' => $value, 'date' => $date]);
                foreach ($entity->goals as $val) {
                    if (!in_array($val->pivot->id, $ids)) $gvalue = $val->pivot;
                }
                $results['value'] = $gvalue;
            }
        }

        return $results;
    }

    /**
     * Deletes rule value to given entity
     * @param $identification
     * @param $id
     * @return array
     */
    public function delvalue($identification, $id)
    {
        $results = [];
        $entity = Entity::firstOrCreate(['identification' => $identification]);
        $values = $entity->rules()->wherePivot('id', $id)->detach();
        $results['values'] = $values;

        return $results;
    }
    /**
     * Deletes goal value to given entity
     * @param $identification
     * @param $id
     * @return array
     */
    public function delgoalvalue($identification, $id)
    {
        $results = [];
        $entity = Entity::firstOrCreate(['identification' => $identification]);
        $values = $entity->goals()->wherePivot('id', $id)->detach();
        $results['values'] = $values;

        return $results;
    }
}
