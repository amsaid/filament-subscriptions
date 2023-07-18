<?php

namespace IbrahimBougaoua\FilamentSubscription\Traits;
use IbrahimBougaoua\FilamentSubscription\Models\Feature;
use IbrahimBougaoua\FilamentSubscription\Models\Plan;
use IbrahimBougaoua\FilamentSubscription\Models\PlanFeature;
use IbrahimBougaoua\FilamentSubscription\Models\PlanSubscription;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait PlanSubscriptions {

    public function planSubscriptions(): MorphMany
    {
        return $this->morphMany(PlanSubscription::class, 'subscriber', 'subscriber_type', 'subscriber_id');
    }

    public function newSubscription(Plan $plan) : PlanSubscription
    {
        return $this->planSubscriptions()->create([
            'name' => $plan->name,
            'slug' => $plan->slug,
            'description' => $plan->description,
            'price' => $plan->price,
            'trial_ends_at' => '2023-07-15 18:55:38.000000',
            'starts_at' => '2023-07-15 18:55:38.000000',
            'ends_at' => '2023-07-20 18:55:38.000000',
            'timezone' => '',
            'plan_id' => $plan->id,
        ]);
    }

    public function planSubscription($slug) : PlanSubscription
    {
        return $this->planSubscriptions()->where('slug',$slug)->first();
    }

    public function subscription() : PlanSubscription
    {
        return $this->planSubscriptions()->latest()->first();
    }

    public function hasSubscribedTo($plan_id) : bool
    {
        $subscription = $this->planSubscriptions()->where('plan_id',$plan_id)->latest()->first();
        if( $subscription && $subscription->active() )
            return true;
        return false;
    }

    public function hasFeature($plan_id,$feature_id) : bool
    {
        $feature = PlanFeature::where('plan_id',$plan_id)->where('feature_id',$feature_id)->first();
        if( $feature )
            return true;
        return false;
    }
}