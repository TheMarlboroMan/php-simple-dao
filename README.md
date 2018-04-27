# php-simple-dao
Proof of concept for a simple PHP Data Access Object

# TODO:

- I will need a couple of entities.
- I will need a provider interface for each entity
- I will need a DAO Object.
- I will need to implement the providers differently for each underlying data strategy.
- I will instantiate a DAO.
- I will feed the DAO with providers for entities ($dao->feed_provider(user::class, new user_db_provider());
- I will then use it like $dao->get(user:class, 'strategy_name', $params)
- $dao->remove($entity);
- $dao->update($entity);
- $dao->insert($entity);
