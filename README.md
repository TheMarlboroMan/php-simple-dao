# php-simple-dao

Proof of concept for a simple PHP Data Access Object

# Base concepts...

- There are [entities] which need to be CRUDed, which are represented by "data_object".
- When I want to CUD an [entity] I do so by asking a [black hole] (represented by "dao") to do the operation for me.
- The [black hole] knows how to execute the operation through a series of [instructions] (the "data accesor"). This instructions can be different for each type of [entity].
- If I need to R (read) an [entity] I ask the [black hole] for a series of valid [ways to retrieve] it (the "data_retriever"). These will be different for each type of [entity] and are dependant on the [instructions].

The important thing here is to know that each [entity] has a set of [ways to retrieve it]. How to do that depends on the [instructions], since these specify where the [entity] resides.
