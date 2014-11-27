@set('someVar', 'ok')
@partial('partials.one')
@block('first', 'ok')
@block('second')
ok
@endblock
@block('third', $someVar)
@endpartial
