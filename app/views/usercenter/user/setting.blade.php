@extends('layouts.main')
@section('header')
<div class="navbar-header">
    <a class="navbar-brand" href="<?php echo route( 'projects' ); ?>">DevelopSpec</a>
</div>
@stop
@section('content')
<div class="body settings">
    <div class="container">
        <div class="page-title">
            <h1 class="pull-left">My DevelopeSpec</h1>
            <a href="https://id.deepdevelop.com" class="pull-right" style="color: #000;">My DeepDevelop ID</a>
            <div class="clearfix"></div>
        </div>
        <hr>
        <table class="table">
            <tbody>
                <tr>
                    <td width="10%">Name</td>
                    <td><strong><?php echo $user->first_name . $user->last_name; ?></strong></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><strong><?php echo $user->email; ?></strong></td>
                </tr>
                <!-- <tr>
                    <td>Plan</td>
                    <td>
                        <p><strong>Unlimited</strong> (using 3 of unlimited projects)
                            —
                            <span data-toggle="tooltip" data-title="Not available in DeepDeploy Beta" data-placement="bottom" data-original-title="" title="">
                                <a class="btn btn-sm btn-primary disabled" href="/pricing">Upgrade plan</a>                     </span>
                            </p>
                            <p>(expiry on 2015-03-06, next plan: <strong>Free</strong>)</p>
                        </td>
                    </tr>
                -->
            </tbody>
        </table>
    </div>
</div>

<script src="<?php echo asset("assets/js/lib/jquery-1.11.0.min.js"); ?>"></script>
<script src="<?php echo asset("assets/js/lib/bootstrap.min.js"); ?>"></script>
@stop