# Hexagonal Approach Oriented Library

[![GPLv3 License](https://img.shields.io/badge/license-GPLv3-marble.svg)](https://www.gnu.org/licenses/gpl-3.0.en.html)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/ticaje/hexagonal.svg?style=flat-square)](https://packagist.org/packages/ticaje/hexagonal)
[![Quality Score](https://img.shields.io/scrutinizer/g/ticaje/Hexagonal-Design-Library.svg?style=flat-square)](https://scrutinizer-ci.com/g/ticaje/Hexagonal-Design-Library)
[![Total Downloads](https://img.shields.io/packagist/dt/ticaje/hexagonal.svg?style=flat-square)](https://packagist.org/packages/ticaje/hexagonal)
[![Author](https://img.shields.io/badge/HBLateral.com-%2302113a?style=labelColor=lightgrey)](https://hblateral.com)

## Installation

You can install this package using composer(the only way i recommend)

```bash
composer require ticaje/hexagonal
```

## Preface

This library settles the basis for a hexagonal-oriented-design based solutions.
It is an API that encourages developers to use a Hexagonal design approach.
We have wanted also to provide room for Command-Bus approach when exposing isolated services in a simple manner to consumers.

## Hexagonal Architecture

Also known as Port and Adapters, this design pattern is sort of a mindset applied to Software modeling when building scalable, testable and maintainable applications.
It stands for a Way of Decoupling Software into smaller Units/Layers/APIs that can also be independently deploy-able and testable.
Every one of those layers has its own boundary-oriented purpose whether in business or infrastructure grounds.
Internet is full of articles and documentation about Hexagonal Design.

**__So Port & Adapters frame two important aspects to Software Design:__**

__On one side there is the intention of creating aforementioned responsibility layers or APIs__

and on the other hand last but not least,

__the way those components interact with each other: these relationships are the core to Hexagonal cause they represent the real value of a Software.__

In reality, Hexagonal(like most of design patterns) is kind of abstract concept, there is no rule that says the pattern has been applied wrongly or properly.

### The preponderance of Interfaces

For me, and this is a personal opinion, the key to Hexagonal Architecture and to O.O.D in general is in Interfaces.
Interfaces are everything to design's good decisions cause, amongst many other uses, they define the way applications interact with each others.

In Hexagonal context, Interfaces are ports that accept requests/data into our applications or APIs.

#### Interfaces in Hexagonal and S.O.L.I.D principles

Interfaces are the key to **D** in **SOLID** principles
Dependency Inversion Principle establishes that high level modules should not depend on low level modules, and both must depend on abstractions; also abstractions should
not depend on details but the other way around, details should depend on abstractions.

This sounds kind of ethereal but it has all the sense of the world in terms of Hexagonal standpoint. the way all of our APIs define and present themselves to the world
should be by using ports whose entry points are interfaces, then following points would be guaranteed:

1. **Multiple Implementations** on all sides, every module uses adapters(different implementations for every interface).
2. **Change encapsulation**: modules remain unalterable to change of other modules since they correlate via interfaces(abstractions)
3. **Law of Demeter**: every module has minimal knowledge of the rest of modules, it only knows what is defined on their service/data contract within the Interfaces themselves. This is quite important cause it normalizes the communications between agencies.
3. **Simpler Testing**: Testing classes/APIs/modules/agencies with little(essential) responsibilities turns out to be much simpler and hence our application more maintainable.

Essentially, Hexagonal architecture is about using interfaces(or equivalents) and abstractions thoroughly to build relationships amongst system components in the same way a writer
creates a novel and profiles characters/stories/timelines in a credible construction to readers. so the purpose of Hexagonal is to communicate system intention in a good story at the same time
that good design principles are achieved.

So Interfaces(Ports) reflect intention and concrete Implementations(Adapters) provide fluent/interchangeable solutions.

## Command Bus Approach

This design pattern is present also in this library cause it can be included in Domain modeling along with Hexagonal design.

The idea behind Command Bus is __having a Command entity(that describes what specific actor wants) and map it to a Handler entity that executes it__. That's it.

This is especially useful when having Service layers that are consumed by other modules, whether high or low level modules.

For this library we are leaning on useful library that is in charge of machinery gearing when it comes to finding handlers for corresponding commands:
[Tactician](https://tactician.thephpleague.com/) takes care of that for us.

We have created a Specific implementor that connects to our Port: BusFacadeInterface via constructor as ImplementorInterface.
Then in a DIC the wiring up is completed.

Example in Laravel(via Contextual Binding).

Imagine we want to inject our Bus implementation to a specific controller in Laravel application, then we just need to inject ImplementorInterface within its constructor and define
the recipe in DIC as something like following snippet:

```php
$this->app->when(ConsumerController::class)
          ->needs(ImplementorInterface::class)
          ->give(function ($app) {
              return ($app->make(Tactician::class));
});
```

A pretty good example of Command-Bus in practice could be having a service that can be consumed by multiple contexts.

Imagine that we have a price API that provides prices according specific business rules.

This API could be consumed from many contexts: Http call, cli command, another API or Message Queue based application

Well, as we can see there must be a unique place where all calls can rely on. Applying Command-Buss approach makes it really simple just by defining a command that is essentially a DTO
that contains all necessary data for the service to operate according business policies and pass that command off to the handler that is actually the actor that wraps the service in stake
and launches its logic.

The Bus is the guy in charge of finding the handler for specific command.

This simplifies the machinery of consuming services since all consumers just need to prepare the Command, instantiate the bus and call its API(sending the command as parameter) to consume the
desired service.

## Credits

- [Héctor Luis Barrientos](https://github.com/ticaje)
- [All Contributors](../../contributors)

## License

The GNU General Public License (GPLv3). Please see [License File](LICENSE.md) for more information.
