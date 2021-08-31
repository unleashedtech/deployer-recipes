<?php
namespace Deployer;

task('dev:todo', function() {
  // TODO: get partent task from context, if possible.
  /** @var \Deployer\Task\Context $context */
  $context = debug_backtrace()[2]['args'][0];
  $task = NULL;

  throw new \BadFunctionCallException('Please implement parent task. Please run `dep tree deploy` for a full list of tasks & dependencies.');
})->local();
