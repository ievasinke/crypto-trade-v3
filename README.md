# Crypto Trading app

This application allows you to manage a virtual portfolio of cryptocurrencies using data from various cryptocurrency
APIs. You can view the top cryptocurrencies, buy and sell them using virtual money, and track your transaction history.

## Getting Started

### Prerequisites

- PHP >= 7.4
- Composer (https://getcomposer.org/) for dependency management
- API keys from supported cryptocurrency APIs:
    - CoinMarketCap (https://coinmarketcap.com/)
    - CoinGecko (https://coingecko.com/)

### Installation

Clone the repository:  
```  git clone https://github.com/ievasinke/crypto-trade-v3.git  ```  
Navigate to the project directory:  
```  cd crypto-trade-v3  ```  
Install dependencies using Composer:  
``` composer install  ```  
Create a `.env` file in the root directory from `.env.example` file and add your API keys:  
``` CRYPTO_API_KEY=your_api_key_here ```  
``` COINGECKO_API_KEY=your_api_key_here ```

### Usage

#### Fetch Data

To fetch the latest cryptocurrency data, you can use either of the following scripts depending on the API provider you
want to use:

- For CoinGecko (default/current setup):  
  ``` php importGecko.php ```
- For CoinMarketCap:  
  ``` php import.php ```

#### Run the application

To start the application, run:  
``` php index.php ```