# Umi is a simple IRC client

import IRC, Config, Logger

# An instance of Config to pull configuration options
conf = Config.Config()

# A Logger object for writing to the Terminal
log = Logger.Logger(conf)

# Establish a connection to the IRC network
Umi = IRC.IRC( conf.network(), log, conf )