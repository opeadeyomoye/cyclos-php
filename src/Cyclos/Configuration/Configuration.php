<?php

namespace Cyclos\Configuration;

class Configuration
{
    /*
     | In a bid to avoid "global state" for config, here's what we'll try:
     | 
     | Have protected, static properties that will hold config.
     | The protected config can ONLY be modified via a static interface, and the only
     | real "modification" that can be done is reload the config from the dotenv file,
     | or reload the default (manually-set) config from wherever that resides.
     |
     | Have static methods to reload the manual or dotenv config into the static properties.
     | This way, we've got global defaults, but dependents use seperate instances, hence we avoid
     | creating a "recipe for disaster" or all that other bad news associated with global variables.
     | 
     | Oh, and we'll probably use an interface for creating config classes. Hmm, we could even
     | make the constructor private, then we'll provide a static interface for creating new instances
     | while avoiding the apparently evil singleton instance.
    */
}
