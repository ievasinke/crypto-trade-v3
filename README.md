# Crypto Trading app

This application allows you to manage a virtual portfolio of cryptocurrencies using data from the CoinMarketCap API. You
can view the top cryptocurrencies, buy and sell them using virtual money, and track your transaction history.

## Getting Started

### Prerequisites

- PHP >= 7.4
- Composer (https://getcomposer.org/) for dependency management
- API key from CoinMarketCap (https://coinmarketcap.com/)

### Installation

Clone the repository:  
```  git clone https://github.com/ievasinke/crypto-trade.git  ```  
Navigate to the project directory:  
```  cd crypto-trade  ```  
Install dependencies using Composer:  
``` composer install  ```  
Create a `.env` file in the root directory and add your CoinMarketCap API key:  
``` CRYPTO_API_KEY=your_api_key_here ```

### Usage

#### Fetch Data

To fetch the latest cryptocurrency data, run:  
``` php import.php ```

#### Run the application

To start the application, run:  
``` php index.php ```