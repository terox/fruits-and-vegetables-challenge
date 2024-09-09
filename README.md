# 🍎🥕 Fruits and Vegetables

## 🎯 Goal
We want to build a service which will take a `request.json` and:
[x] Process the file and create two separate collections for `Fruits` and `Vegetables`
[x] Each collection has methods like `add()`, `remove()`, `list()`;
[x] Units have to be stored as grams;
[x] Store the collections in a storage engine of your choice. (e.g. Database, In-memory)
[x] Provide an API endpoint to query the collections. As a bonus, this endpoint can accept filters to be applied to the returning collection.
[x] Provide another API endpoint to add new items to the collections (i.e., your storage engine).

As a bonus you might:
[x] consider giving an option to decide which units are returned (kilograms/grams);
[x] how to implement `search()` method collections;
[x] use latest version of Symfony's to embed your logic 

### ✔️ How can I check if my code is working?
You have two ways of moving on:
* You call the Service from PHPUnit test like it's done in dummy test (just run `bin/phpunit` from the console)

or

* You create a Controller which will be calling the service with a json payload

## 💡 Hints before you start working on it
* Keep KISS, DRY, YAGNI, SOLID principles in mind
* Timebox your work - we expect that you would spend between 3 and 4 hours.
* Your code should be tested

## When you are finished
* Please upload your code to a public git repository (i.e. GitHub, Gitlab)

## Personal approach: some notes about how I try to resolve the goals
I decided to implement a **DDD and Hexagonal Architecture** approach. Maybe it's a little over-engineered, but I tried
to demostrate some of my knowledge in that little challenge. So, all maybe it's opinable and improvable. So I open to
learn and fix if it has sense. Some keys:
1. There are a strong separation between layers: Infrastructure, Application and Domain
2. I tried to avoid pollute the Domain and Value Objects with third party libraries.
3. The methods to access to collection (Redis, MySQL...) are implement through use cases (Add, List and Remove). 
   **Why?** In complex projects keep it in that way I think could be a lot of benefits because you have all the business logic of determinate domain encapsulated.
4. Modules ```Fruit/``` and ```Vegetable/``` are copies basically: "prefer duplication over the wrong abstraction".
   **Why?** In real projects maybe the modules evolve in different ways and trying to keep an abstraction could be hard.
   It depends on the project and the trade-off assumed by the team. Also, we could promote one module to a Bounded Context
   (or a microservice?). I think that it's important to keep in mind.
5. **Shared/** directories contain the shared elements between modules o bound contexts.

## 🐳 Docker image
Optional. Just here if you want to run it isolated.

### 📥 Pulling image
```bash
docker pull tturkowski/fruits-and-vegetables
```

### 🧱 Building image
```bash
docker build -t tturkowski/fruits-and-vegetables -f docker/Dockerfile .
```

### Launching isolated environment
```bash
docker compose up
```

### Loading request.json
```bash
sh bin/load-request-file
```

### 🏃‍♂️ Running container
```bash
sh bin/container
```

### 🛂 Running tests
```bash
sh bin/tests
```

### ⌨️ Run development server
```bash
sh bin/server
# Open http://127.0.0.1:8080 in your browser
```
